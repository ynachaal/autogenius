<?php

namespace App\Http\Controllers;

use App\Models\CarInsurance; 
use App\Models\Payment;
use App\Services\EmailService;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class ServiceInsuranceClaimController extends Controller
{
    protected $emailService;
    protected $pageService;

    public function __construct(EmailService $emailService, PageService $pageService)
    {
        $this->emailService = $emailService;
        $this->pageService = $pageService;
    }

    /**
     * Store the request and initiate Razorpay Order
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validate including File Uploads
        $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_mobile' => 'required|string|max:20',
            'vehicle_reg_no'  => 'required|string|max:20',
            'rc_photo'        => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'insurance_photo' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'cf-turnstile-response' => 'required',
        ]);

        // 2. Turnstile Verification
        try {
            $turnstile = Http::asForm()->timeout(5)->post(
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                [
                    'secret'   => config('services.turnstile.secret_key'),
                    'response' => $request->input('cf-turnstile-response'),
                    'remoteip' => $request->ip(),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Insurance Turnstile Error: ' . $e->getMessage());
            return back()->with('error', 'Security service unavailable.');
        }

        if (!$turnstile->json('success')) {
            return back()->withErrors(['cf-turnstile-response' => 'Captcha verification failed.'])->withInput();
        }

        // 3. Handle File Storage
        $rcPath = $request->file('rc_photo')->store('insurance/rc', 'public');
        $insPath = $request->file('insurance_photo')->store('insurance/insurance', 'public');

        // 4. Create record
        $insurance = CarInsurance::create([
            'customer_name'   => $request->customer_name,
            'customer_mobile' => $request->customer_mobile,
            'vehicle_reg_no'  => $request->vehicle_reg_no,
            'rc_path'         => $rcPath,
            'insurance_path'  => $insPath,
            'status'          => 'pending',
        ]);

        // 5. Razorpay Order Creation
        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $amountInPaise = 50000; // ₹500

            $order = $api->order->create([
                'receipt'  => 'ins_history_' . $insurance->id,
                'amount'   => $amountInPaise,
                'currency' => 'INR',
                'notes'    => [
                    'insurance_id' => $insurance->id,
                    'customer'     => $insurance->customer_name,
                ],
            ]);

            Payment::create([
                'entity_type'     => CarInsurance::class,
                'entity_id'       => $insurance->id,
                'gateway'         => 'razorpay',
                'order_id'        => $order['id'],
                'amount'          => $amountInPaise,
                'currency'        => 'INR',
                'status'          => 'pending',
                'gateway_payload' => $order->toArray(),
            ]);

            return redirect()->signedRoute('insurance.payment', ['insurance' => $insurance->id]);

        } catch (\Exception $e) {
            Log::error('Insurance Razorpay Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to initiate payment.');
        }
    }

    /**
     * Verify the payment from Razorpay
     */
    public function verifyPayment(Request $request)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);

            $payment = Payment::where('order_id', $request->razorpay_order_id)
                ->where('entity_type', CarInsurance::class)
                ->firstOrFail();

            $payment->update([
                'payment_id' => $request->razorpay_payment_id,
                'signature'  => $request->razorpay_signature,
                'status'     => 'paid',
                'paid_at'    => now(),
            ]);

            $insurance = CarInsurance::findOrFail($payment->entity_id);
            $insurance->update(['status' => 'confirmed']);

            // Notify Admin (Uncomment when EmailService method is ready)
            // $this->emailService->insuranceHistoryAdminNotification($insurance);

            return redirect()->route('insurance.thank-you')->with('success', 'Payment successful');

        } catch (\Exception $e) {
            Log::error('Insurance Payment Verify Failed: ' . $e->getMessage());
            return redirect()->route('lead.payment.failed');
        }
    }

    public function payment(CarInsurance $insurance)
    {
        $paid = $insurance->payments()->where('status', 'paid')->exists();

        if ($paid) {
            return redirect()->route('insurance.thank-you');
        }

        $payment = $insurance->payments()->latest()->first();

        return view('front.insurance.payment', [
            'insurance'   => $insurance,
            'payment'     => $payment,
            'razorpayKey' => config('services.razorpay.key'),
        ]);
    }

    public function thankYou()
    {
        $response = 'Your Inquiry Has Been Successfully Received. We will get back to you within 3 Hours.';
        return view('front.insurance.thank-you', compact('response'));
    }
}
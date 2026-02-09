<?php

namespace App\Http\Controllers;

use App\Models\CarInspection;
use App\Services\EmailService;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class CarInspectionController extends Controller
{
    protected $emailService;
    protected $pageService;

    public function __construct(EmailService $emailService, PageService $pageService)
    {
        $this->emailService = $emailService;
        $this->pageService = $pageService;
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Validate (matching your form names)
        $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_mobile' => 'required|string|max:20',
            'customer_email'  => 'required|email',
            'vehicle_name'    => 'required|string|max:255',
            'pdi_date'        => 'required|digits:6', 
            'pdi_location'    => 'required|string|max:255',
            'cf-turnstile-response' => 'required',
        ]);

        // 2. Verify Cloudflare Turnstile
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
            Log::error('PDI Turnstile Error: ' . $e->getMessage());
            return back()->with('error', 'Security service unavailable. Try again.');
        }

        if (!$turnstile->json('success')) {
            return back()->withErrors(['cf-turnstile-response' => 'Captcha verification failed.'])->withInput();
        }

        // 3. Create Inspection Record (Mapped to your DB columns)
        $inspection = CarInspection::create([
            'customer_name'       => $request->customer_name,
            'customer_mobile'     => $request->customer_mobile,
            'customer_email'      => $request->customer_email,
            'vehicle_name'        => $request->vehicle_name,
            'inspection_date'     => $request->pdi_date,
            'inspection_location' => $request->pdi_location,
            'payment_status'      => 'pending',
            'status'              => 'pending',
        ]);

        // 4. Create Razorpay Order
        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

          $amountInPaise = 50000; // ₹500.00 (Razorpay uses paise)
            $order = $api->order->create([
                'receipt'  => 'car_inspection_' . $inspection->id,
                'amount'   => $amountInPaise,
                'currency' => 'INR',
                'notes'    => [
                    'inspection_id' => $inspection->id,
                    'customer'      => $inspection->customer_name,
                ],
            ]);

            // 5. Update Record with Order Details
            $inspection->update([
                'razorpay_order_id' => $order['id'],
                'amount_paid'       => $amountInPaise,
                'payment_for'       => 'PDI Car Inspection',
            ]);

            // 6. Redirect to signed payment route
            return redirect()->signedRoute('inspection.payment', ['inspection' => $inspection->id]);

        } catch (\Exception $e) {
            Log::error('PDI Razorpay Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to initiate payment. Please try again.');
        }
    }

    public function verifyPayment(Request $request)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);

            $inspection = CarInspection::where('razorpay_order_id', $request->razorpay_order_id)->firstOrFail();

            $inspection->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
                'payment_status'      => 'paid',
                'status'              => 'confirmed',
                'paid_at'             => now(),
            ]);

            // Trigger notification
           // $this->emailService->sendInspectionAdminNotification($inspection);

            return redirect()->route('inspection.thank-you')->with('success', 'Payment verified successfully');
        } catch (\Exception $e) {
            Log::error('PDI Payment Verify Failed: ' . $e->getMessage());
            return redirect()->route('inspection.payment.failed');
        }
    }

    public function payment(CarInspection $inspection)
    {
        if ($inspection->payment_status === 'paid') {
            return redirect()->route('inspection.thank-you');
        }

        return view('front.inspection.payment', [
            'inspection'  => $inspection,
            'razorpayKey' => config('services.razorpay.key'),
        ]);
    }
}
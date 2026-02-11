<?php

namespace App\Http\Controllers;

use App\Models\ServiceInsuranceClaim;
use App\Models\Payment;
use App\Services\EmailService;
use App\Services\PageService;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use App\Services\ServiceService;

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
    public function store(Request $request, ServiceService $serviceService): RedirectResponse
    {
        // 1. Validate including File Uploads and Turnstile
        $request->validate([
            'customer_name' => 'required|string|min:2|max:100',
            'customer_email' => 'required|email|max:254',
            'customer_mobile' => 'required|string|min:7|max:20',
            'rc_photo' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'insurance_photo' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'cf-turnstile-response' => 'required',
            'page_slug' => 'required|string',
        ]);

        $slug = $request->input('page_slug');

        // 2. Fetch Dynamic Amount from Service
        $amountValue = $serviceService->getAmountBySlug($slug);

        if (!$amountValue) {
            return redirect()->back()->with('error', 'Service pricing information not found.');
        }

        // Convert to Paise (e.g., 500 -> 50000)
        $amountInPaise = $amountValue * 100;

        $page = Page::where('slug', $slug)->first();
        $serviceName = $page ? $page->title : ucwords(str_replace('-', ' ', $slug));

        // 3. Turnstile Verification
        try {
            $turnstile = Http::asForm()->timeout(5)->post(
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                [
                    'secret' => config('services.turnstile.secret_key'),
                    'response' => $request->input('cf-turnstile-response'),
                    'remoteip' => $request->ip(),
                ]
            );

            if (!$turnstile->json('success')) {
                return back()->withErrors(['cf-turnstile-response' => 'Captcha verification failed.'])->withInput();
            }
        } catch (\Exception $e) {
            Log::error('Insurance Turnstile Error: ' . $e->getMessage());
            return back()->with('error', 'Security service unavailable. Please try again later.');
        }

        // 4. Handle File Storage
        $rcPath = $request->file('rc_photo')->store('insurance/rc', 'public');
        $insPath = $request->file('insurance_photo')->store('insurance/insurance', 'public');

        // 5. Create record
        $insurance = ServiceInsuranceClaim::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_mobile' => $request->customer_mobile,
            'rc_path' => $rcPath,
            'insurance_path' => $insPath,
            'service_type' => $serviceName,
            'status' => 'pending',
        ]);

        // 6. Razorpay Order Creation
        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $order = $api->order->create([
                'receipt' => 'ins_history_' . $insurance->id,
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'notes' => [
                    'insurance_id' => $insurance->id,
                    'customer' => $insurance->customer_name,
                    'customer_email' => $insurance->customer_email,
                    'service_type' => $insurance->service_type,
                ],
            ]);

            Payment::create([
                'entity_type' => ServiceInsuranceClaim::class,
                'entity_id' => $insurance->id,
                'gateway' => 'razorpay',
                'order_id' => $order['id'],
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'status' => 'pending',
                'gateway_payload' => $order->toArray(),
            ]);

            return redirect()->signedRoute('service-insurance.payment', ['insurance' => $insurance->id]);

        } catch (\Exception $e) {
            Log::error('Service Insurance Razorpay Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to initiate payment gateway.');
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
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            $payment = Payment::where('order_id', $request->razorpay_order_id)
                ->where('entity_type', ServiceInsuranceClaim::class)
                ->firstOrFail();

            $payment->update([
                'payment_id' => $request->razorpay_payment_id,
                'signature' => $request->razorpay_signature,
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $insurance = ServiceInsuranceClaim::findOrFail($payment->entity_id);
            $insurance->update(['status' => 'confirmed']);

            // Notify Admin
            try {
                // Calling the new method added to EmailService
                $this->emailService->serviceInsuranceClaimAdminNotification($insurance);
            } catch (\Exception $e) {
                Log::error('Failed to send Service Insurance Admin Email: ' . $e->getMessage());
            }

            try {
                if (method_exists($this->emailService, 'serviceInsuranceClaimUserConfirmation')) {
                    $this->emailService->serviceInsuranceClaimUserConfirmation($insurance);
                }
            } catch (\Exception $e) {
                Log::error('Failed to send Service Insurance User Confirmation: ' . $e->getMessage());
            }

            return redirect()->route('payment.success')->with([
                'title' => 'Claim Request Received!',
                'message' => 'Your Inquiry Has Been Successfully Received. We will get back to you within 3 Hours.'
            ]);

        } catch (\Exception $e) {
            Log::error('Service Insurance Payment Verify Failed: ' . $e->getMessage());
            return redirect()->route('payment.failed');
        }
    }

    /**
     * Show Payment Page
     */
    public function payment(ServiceInsuranceClaim $insurance)
    {
        $paid = $insurance->payments()->where('status', 'paid')->exists();

        if ($paid) {
            return redirect()->route('payment.success');
        }

        $payment = $insurance->payments()->latest()->first();

        if (!$payment) {
            return redirect()->back()->with('error', 'Payment session not found.');
        }

        return view('front.service-insurance.payment', [
            'insurance' => $insurance,
            'payment' => $payment,
            'razorpayKey' => config('services.razorpay.key'),
        ]);
    }
}
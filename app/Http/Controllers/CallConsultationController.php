<?php

namespace App\Http\Controllers;

use App\Models\CallConsultation;
use App\Models\Payment;
use App\Models\Page;
use App\Services\EmailService;
use App\Services\PageService;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class CallConsultationController extends Controller
{
    protected $emailService;
    protected $pageService;

    public function __construct(EmailService $emailService, PageService $pageService)
    {
        $this->emailService = $emailService;
        $this->pageService = $pageService;
    }

    public function store(Request $request, ServiceService $serviceService): RedirectResponse
    {
        // 1. Validation
        $request->validate([
               'customer_name' => 'required|string|min:2|max:100',
            'customer_mobile' => 'required|string|max:20',
            'customer_email' => 'required|email|max:254',
            'selected_service' => 'required|string', // The choice from dropdown
            'service_type' => 'required|string',    // The hidden category slug
            'cf-turnstile-response' => 'required',
        ]);

        // 2. Fetch Amount (Logic: get from slug, fallback to 499)
        $slug = $request->input('service_type');
        $amount = $serviceService->getAmountBySlug($slug) ?: 499;

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
        } catch (\Exception $e) {
            Log::error('Consultation Turnstile Error: ' . $e->getMessage());
            return back()->with('error', 'Security service unavailable. Try again.');
        }

        if (!$turnstile->json('success')) {
            return back()->withErrors(['cf-turnstile-response' => 'Captcha verification failed.'])->withInput();
        }

        // 4. Create Call Consultation Record
        $consultation = CallConsultation::create([
            'customer_name' => $request->customer_name,
            'customer_mobile' => $request->customer_mobile,
            'customer_email' => $request->customer_email,
            'selected_service' => $request->selected_service,
            'service_type' => $request->service_type,
            'status' => 'pending',
        ]);

        // 5. Razorpay Order Creation
        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            $amountInPaise = $amount * 100;

            $order = $api->order->create([
                'receipt' => 'consultation_' . $consultation->id,
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'notes' => [
                    'consultation_id' => $consultation->id,
                    'customer' => $consultation->customer_name,
                    'service' => $consultation->selected_service,
                ],
            ]);

            // Create Payment entry (Polymorphic)
            Payment::create([
                'entity_type' => CallConsultation::class,
                'entity_id' => $consultation->id,
                'gateway' => 'razorpay',
                'order_id' => $order['id'],
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'status' => 'pending',
                'gateway_payload' => $order->toArray(),
            ]);

            return redirect()->signedRoute('call-consultation.payment', ['consultation' => $consultation->id]);

        } catch (\Exception $e) {
            Log::error('Consultation Razorpay Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to initiate payment. Please try again.');
        }
    }

    public function payment(CallConsultation $consultation)
    {
        if ($consultation->isPaid()) {
            return redirect()->route('payment.success');
        }

        $payment = $consultation->payments()->latest()->first();

        return view('front.consultation.payment', [
            'consultation' => $consultation,
            'payment' => $payment,
            'razorpayKey' => config('services.razorpay.key'),
        ]);
    }

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
                ->where('entity_type', CallConsultation::class)
                ->firstOrFail();

            $payment->update([
                'payment_id' => $request->razorpay_payment_id,
                'signature' => $request->razorpay_signature,
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $consultation = CallConsultation::findOrFail($payment->entity_id);
            $consultation->update(['status' => 'confirmed']);

            if (method_exists($this->emailService, 'callConsultationAdminNotification')) {
                $this->emailService->callConsultationAdminNotification($consultation);
            }

            if (method_exists($this->emailService, 'callConsultationUserConfirmation')) {
                $this->emailService->callConsultationUserConfirmation($consultation);
            }

            return redirect()->route('payment.success')
                ->with('message', 'Your Inquiry Has Been Successfully Received. We will get back to you within 2 working hours.');

        } catch (\Exception $e) {
            Log::error('Consultation Payment Verify Failed: ' . $e->getMessage());
            return redirect()->route('payment.failed');
        }
    }
}
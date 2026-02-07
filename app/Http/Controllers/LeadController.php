<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; // <--- Ensure this is here
use Illuminate\View\View;
use App\Services\PageService;
use Illuminate\Support\Facades\Http;
use App\Services\EmailService; // <--- Import the Service
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    protected $emailService;
    protected $pageService;



    public function __construct(EmailService $emailService, PageService $pageService)
    {
        $this->emailService = $emailService;
        $this->pageService = $pageService;
    }
    public function index(): View
    {
        $page = $this->pageService->getBySlug('smart-car-requirements');
        return view('front.lead.index', compact('page'));
    }

    /**
     * Handles both the initial "Continue" from Step 1 
     * and the Final Form Submission.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validate
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|min:10',
            'city' => 'required|string',
            'cf-turnstile-response' => 'required',
        ], [
            'cf-turnstile-response.required' => 'Please complete the security check.',
        ]);

        // 2. Turnstile verify
        try {
            $turnstile = Http::asForm()
                ->timeout(5)
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => config('services.turnstile.secret_key'),
                    'response' => $request->input('cf-turnstile-response'),
                    'remoteip' => $request->ip(),
                ]);
        } catch (\Exception $e) {
            Log::error('Lead Turnstile Error: ' . $e->getMessage());
            return back()->with('error', 'Security service unavailable. Try again.');
        }

        if (!$turnstile->json('success')) {
            return back()->withErrors(['cf-turnstile-response' => 'Captcha verification failed.'])->withInput();
        } 

        // 3. Map lead data
        $data = [
            'full_name' => $request->name,
            'mobile' => $request->mobile,
            'city' => $request->city,
            'service_required' => $request->service,
            'preferred_contact_method' => $request->contact,
            'budget' => $request->budget,
            'max_budget' => $request->stretch_budget,
            'ownership_period' => $request->ownership,
            'primary_usage' => $request->usage,
            'running_pattern' => $request->running_pattern,
            'approx_running' => $request->running_km,
            'passengers' => $request->passengers_usually,
            'body_type' => $request->body_type,
            'fuel_preference' => $request->fuel,
            'gearbox' => $request->gearbox_preference,
            'ride_comfort' => $request->comfort_priority,
            'feature_priority' => $request->feature_priority,
            'noise_sensitivity' => $request->noise_sensitivity,
            'color_preference' => $request->Colour,
            'max_owners' => $request->max_acceptable,
            'accident_history' => $request->History,
            'insurance_preference' => $request->Preference,
            'purchase_timeline' => $request->Purchase,
            'decision_maker' => $request->Decision,
            'existing_car' => $request->Existing,
            'upgrade_reason' => $request->Reason,
            'declaration' => $request->has('confirm'),

            // Payment
            'payment_status' => 'pending',
        ];

        // 4. Create Lead
        $lead = Lead::create($data);

        // 5. Create Razorpay Order
        $api = new \Razorpay\Api\Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $amountInPaise = 9900; // ₹499.00 (example)

        $order = $api->order->create([
            'receipt' => 'lead_' . $lead->id,
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'notes' => [
                'lead_id' => $lead->id,
                'mobile' => $lead->mobile,
            ],
        ]);

        // 6. Save order ID
        $lead->update([
            'razorpay_order_id' => $order['id'],
            'amount_paid' => $amountInPaise,
        ]);

        // 7. Send admin email (optional before payment)
        if ($request->has('confirm')) {
            $this->emailService->sendLeadAdminNotification($lead);
        }

        // 8. Redirect to payment page (or open Razorpay checkout)
        return redirect()->signedRoute('lead.payment', ['lead' => $lead->id]);
    }
    public function verifyPayment(Request $request)
    {
        $api = new \Razorpay\Api\Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            $lead = Lead::where('razorpay_order_id', $request->razorpay_order_id)->firstOrFail();

            $lead->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            return redirect()->route('lead.thank-you')->with('success', 'Payment successful');
        } catch (\Exception $e) {
            Log::error('Razorpay Verify Failed: ' . $e->getMessage());
            return redirect()->route('lead.payment.failed');
        }
    }

    public function payment(Lead $lead)
    {
        if ($lead->payment_status === 'paid') {
            return redirect()->route('lead.thank-you');
        }

        return view('front.lead.payment', [
            'lead' => $lead,
            'razorpayKey' => config('services.razorpay.key'),
        ]);
    }
    public function paymentFailed()
    {
        // You can optionally pass data here if you want to show specific error messages
        return view('front.lead.payment-failed');
    }

    public function thankYou()
    {
        return view('front.lead.thank-you');
    }
}
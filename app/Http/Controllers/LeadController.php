<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Payment;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Page;
use Illuminate\View\View;
use App\Services\PageService;
use Illuminate\Support\Facades\Http;
use App\Services\EmailService;
use Illuminate\Support\Facades\Log;
use App\Services\ServiceService; // Don't forget to import the service

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
     * Handles lead creation + Razorpay order creation
     */
    public function store(Request $request, ServiceService $serviceService): RedirectResponse
    {
        // 1. Validate
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|min:10',
            'city' => 'required|string',
             'page_slug' => 'required|string', 
        ]);

        
        $slug = $request->input('page_slug');

        // 3. Call your service to get the amount
        $amount = $serviceService->getAmountBySlug($slug);

        $page = Page::where('slug', $slug)->first();
        $serviceName = $page ? $page->title : ucwords(str_replace('-', ' ', $slug));



        if (!$amount) {
            return redirect()->back()->with('error', 'Service amount not found.');
        }

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
            'service_type'     => $serviceName, // The new field
            'declaration' => $request->has('confirm'),
        ];

        // 4. Create Lead
        $lead = Lead::create($data);

        // 5. Create Razorpay Order
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $amountInPaise = $amount*100; // ₹99.00

        $order = $api->order->create([
            'receipt' => 'lead_' . $lead->id,
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'notes' => [
                'lead_id' => $lead->id,
                'mobile' => $lead->mobile,
                'service_type' => $lead->service_type,
            ],
        ]);

        // 6. Create Payment record
        Payment::create([
            'entity_type' => Lead::class,   // ✅ CORRECT
            'entity_id' => $lead->id,
            'gateway' => 'razorpay',
            'order_id' => $order['id'],
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'status' => 'pending',
            'gateway_payload' => $order->toArray(),
        ]);

        // 7. Redirect to payment page
        return redirect()->signedRoute('lead.payment', ['lead' => $lead->id]);
    }

    /**
     * Razorpay verify callback
     */
    public function verifyPayment(Request $request)
    {
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            $payment = Payment::where('order_id', $request->razorpay_order_id)
                ->where('entity_type', Lead::class)   // ✅ CORRECT
                ->firstOrFail();

            $payment->update([
                'payment_id' => $request->razorpay_payment_id,
                'signature' => $request->razorpay_signature,
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $lead = Lead::findOrFail($payment->entity_id);

            // Send email after payment
            if ($lead->declaration) {
                $this->emailService->sendLeadAdminNotification($lead);
            }

            return redirect()->route('lead.thank-you')->with('success', 'Payment successful');
        } catch (\Exception $e) {
            Log::error('Razorpay Verify Failed: ' . $e->getMessage());
            return redirect()->route('lead.payment.failed');
        }
    }

    public function payment(Lead $lead)
    {
        $paid = $lead->payments()
            ->where('status', 'paid')
            ->exists();

        if ($paid) {
            return redirect()->route('lead.thank-you');
        }

        $payment = $lead->payments()
            ->latest()
            ->first();

        return view('front.lead.payment', [
            'lead' => $lead,
            'payment' => $payment,
            'razorpayKey' => config('services.razorpay.key'),
        ]);
    }

    public function paymentFailed()
    {
        return view('front.lead.payment-failed');
    }

    public function thankYou()
    {
        $response = 'Your Inquiry Has Been Successfully Received. We will get back to you within 24 Hours.';
        return view('front.lead.thank-you', compact('response'));
    }
}

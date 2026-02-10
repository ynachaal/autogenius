<?php

namespace App\Http\Controllers;

use App\Models\CarInspection;
use App\Models\Payment;
use App\Services\ServiceService; // Don't forget to import the service
use App\Models\Page;
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

    public function store(Request $request, ServiceService $serviceService): RedirectResponse
    {
        $request->validate([

            'customer_name' => 'required|string|max:255',
            'customer_mobile' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'vehicle_name' => 'required|string|max:255',
            'pdi_date' => 'required|date',
            'pdi_location' => 'required|string|max:255',
            'page_slug' => 'required|string', // The hidden input from your form
            'cf-turnstile-response' => 'required',
        ]);



        $slug = $request->input('page_slug');

        // 3. Call your service to get the amount
        $amount = $serviceService->getAmountBySlug($slug);



        if (!$amount) {
            return redirect()->back()->with('error', 'Service amount not found.');
        }

        // Turnstile verify
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
            Log::error('PDI Turnstile Error: ' . $e->getMessage());
            return back()->with('error', 'Security service unavailable. Try again.');
        }

        if (!$turnstile->json('success')) {
            return back()->withErrors(['cf-turnstile-response' => 'Captcha verification failed.'])->withInput();
        }

        $page = Page::where('slug', $request->page_slug)->first();
        $serviceName = $page ? $page->title : ucwords(str_replace('-', ' ', $request->page_slug));



        $formattedDate = $request->pdi_date; // Already Y-m-d from flatpickr

        // Create inspection
        $inspection = CarInspection::create([
            'customer_name' => $request->customer_name,
            'customer_mobile' => $request->customer_mobile,
            'customer_email' => $request->customer_email,
            'vehicle_name' => $request->vehicle_name,
            'inspection_date' => $formattedDate, // Saved as real DATE
            'service_type' => $serviceName, // Now saves "Pre-Delivery Inspection" instead of "pre-delivery-inspection"
            'inspection_location' => $request->pdi_location,
            'status' => 'pending',
        ]);

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $amountInPaise = $amount * 100; // ₹500

            $order = $api->order->create([
                'receipt' => 'car_inspection_' . $inspection->id,
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'notes' => [
                    'inspection_id' => $inspection->id,
                    'customer' => $inspection->customer_name,
                    'service_type' => $inspection->service_type,
                ],
            ]);

            // Create Payment entry
            Payment::create([
                'entity_type' => CarInspection::class,
                'entity_id' => $inspection->id,
                'gateway' => 'razorpay',
                'order_id' => $order['id'],
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'status' => 'pending',
                'gateway_payload' => $order->toArray(),
            ]);

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
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            $payment = Payment::where('order_id', $request->razorpay_order_id)
                ->where('entity_type', CarInspection::class)
                ->firstOrFail();

            $payment->update([
                'payment_id' => $request->razorpay_payment_id,
                'signature' => $request->razorpay_signature,
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $inspection = CarInspection::findOrFail($payment->entity_id);
            $inspection->update(['status' => 'confirmed']);

            $this->emailService->carInspectionAdminNotification($inspection);

          return redirect()->route('payment.success')
        ->with('message', 'Your Inquiry Has Been Successfully Received. We will get back to you within 24 Hours.');

        } catch (\Exception $e) {

            Log::error('PDI Payment Verify Failed: ' . $e->getMessage());
           return redirect()->route('payment.failed');
        }
    }

    public function payment(CarInspection $inspection)
    {
        $paid = $inspection->payments()->where('status', 'paid')->exists();

        if ($paid) {
            return redirect()->route('inspection.thank-you');
        }

        $payment = $inspection->payments()->latest()->first();

        return view('front.inspection.payment', [
            'inspection' => $inspection,
            'payment' => $payment,
            'razorpayKey' => config('services.razorpay.key'),
        ]);
    }

  
}

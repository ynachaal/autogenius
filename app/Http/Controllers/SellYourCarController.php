<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellYourCar;
use Illuminate\Support\Facades\Storage;
use App\Services\EmailService;
use Illuminate\Support\Facades\Http;

class SellYourCarController extends Controller
{
    protected EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function store(Request $request)
    {
        // 1. Validate the incoming data + turnstile
        $validated = $request->validate([
            'vehicle_name' => 'required|string|max:255',
            'year' => 'required|digits:4',
            'kms_driven' => 'required|numeric',
            'no_of_owners' => 'required|integer',
            'registration_number' => 'required|string|max:50',
            'car_location' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'customer_mobile' => 'required|string|max:20',
            'car_photos' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
          'cf-turnstile-response' => 'required', 
        ], [
            'cf-turnstile-response.required' => 'Please complete the security check.', 
        ]);

        // 🔐 Verify Turnstile (same as Contact)
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
            \Log::error('Sell Your Car Turnstile Error: ' . $e->getMessage());
            return back()->with('error', 'Security service temporarily unavailable.')->withInput();
        }

        if (!$turnstile->json('success')) {
            return back()
                ->withErrors(['cf-turnstile-response' => 'Captcha verification failed. Please try again.'])
                ->withInput();
        }

        // Remove turnstile from payload before DB insert
        unset($validated['cf-turnstile-response']);

        // 2. Handle file upload
        if ($request->hasFile('car_photos')) {
            $path = $request->file('car_photos')->store('cars', 'public');
            $validated['car_photos'] = $path;
        }

        // 3. Save to DB
        $sellYourCar = SellYourCar::create($validated);

        // 4. Send Admin Email
          $this->emailService->sellYourCarAdminNotification($sellYourCar); 

          if (method_exists($this->emailService, 'sellYourCarUserConfirmation')) {
            $this->emailService->sellYourCarUserConfirmation($sellYourCar);
        }

        // 5. Redirect
        return redirect()->route('payment.success')->with([
    'title'   => 'Listing Received!',
    'message' => 'Your Inquiry Has Been Successfully Received. We will get back to you within 24 Hours.'
]);
    }

}

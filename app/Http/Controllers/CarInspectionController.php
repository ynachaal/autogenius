<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CarInspectionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_mobile' => 'required|string|max:20',
            'vehicle_name'    => 'required|string|max:255',
            'pdi_date'        => 'required|digits:6', // or change to date if you switch input type
            'pdi_location'    => 'required|string|max:255',
            'cf-turnstile-response' => 'required',
        ]);

        // Verify Cloudflare Turnstile
        $response = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret'   => config('services.turnstile.secret_key'),
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(),
            ]
        );

        if (!($response->json('success') ?? false)) {
            return back()->withErrors([
                'cf-turnstile-response' => 'Captcha verification failed. Try again.',
            ])->withInput();
        }

        //  Save booking (DB, email, CRM, etc.)
        // CarInspection::create([...]);

        return back()->with('success', 'Your inspection has been booked successfully.');
    }
}

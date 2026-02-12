<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarLoan;
use App\Services\EmailService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CarLoanController extends Controller
{
    protected EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function store(Request $request)
    {
        // 1. Validate the data (Now including customer_email)
        $validated = $request->validate([
            'loan_type' => 'required|in:New Car Loan,Used Car Loan',
            'customer_name' => 'required|string|min:2|max:100',
            'customer_email' => 'required|email|max:254', // Added validation for email
            'customer_mobile' => 'required|string|min:7|max:20',
            'city' => 'required|string|min:2|max:100',
            'cf-turnstile-response' => 'required',
        ], [
            'cf-turnstile-response.required' => 'Please complete the security check.',
        ]);

        // 🔐 Verify Cloudflare Turnstile
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
            Log::error('Car Loan Turnstile Error: ' . $e->getMessage());
            return back()->with('error', 'Security service unavailable.')->withInput();
        }

        if (!$turnstile->json('success')) {
            return back()
                ->withErrors(['cf-turnstile-response' => 'Captcha verification failed.'])
                ->withInput();
        }

        // Remove turnstile from data before DB insert
        unset($validated['cf-turnstile-response']);

        // 2. Save to Database
        $loanApplication = CarLoan::create($validated);

        // 3. Send Emails via EmailService
        try {
            $this->emailService->carLoanAdminNotification($loanApplication);

            // Send confirmation to the customer
            $this->emailService->carLoanUserConfirmation($loanApplication);
        } catch (\Exception $e) {
            Log::error('Email failed for Car Loan: ' . $e->getMessage());
        }
        // 4. Redirect with Success Message
        $phone = config('settings.phone', '');

        return redirect()->route('payment.success')->with([
            'title' => 'Application Received!',
            'message' => 'Thank you for choosing AutoGenius. Our loan experts will call you within 24 hours to discuss your ' . $loanApplication->loan_type . '. ' .
                ($phone ? "If you have urgent questions, feel free to contact us at $phone." : "")
        ]);
    }
}
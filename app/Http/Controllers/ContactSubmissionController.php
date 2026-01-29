<?php

namespace App\Http\Controllers;
use App\Services\EmailService;
use Illuminate\Http\Request;
use App\Models\ContactSubmission;
use App\Services\PageService;
use Illuminate\Support\Facades\Http;

class ContactSubmissionController extends Controller
{
    protected EmailService $emailService;
    protected PageService $pageService;

    public function __construct(
        EmailService $emailService,
        PageService $pageService,
    ) {
        $this->pageService = $pageService;
        $this->emailService = $emailService;
    }
    /**
     * Show contact form
     */
    public function create()
    {
        $page = $this->pageService->getBySlug('contact-us');
        return view('front.contact-us', compact('page'));
    }

    /**
     * Store contact submission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_no' => 'required|string|max:20',
            'message' => 'required|string',
            'cf-turnstile-response' => 'required',
        ], [
            // Custom message for better UX
            'cf-turnstile-response.required' => 'Please complete the security check.',
        ]);

        // 🔐 Verify Turnstile with a 5-second timeout
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
            \Log::error('Contact Turnstile Error: ' . $e->getMessage());
            return back()->with('error', 'Security service temporarily unavailable.')->withInput();
        }

        if (!$turnstile->json('success')) {
            return back()
                // Link error to the turnstile response key
                ->withErrors(['cf-turnstile-response' => 'Captcha verification failed. Please try again.'])
                ->withInput();
        }

        // Clean up data for database and email
        unset($validated['cf-turnstile-response']);

        // Send Email
        $this->emailService->contactUs((object) $validated);

        // Save to Database
        ContactSubmission::create($validated);

        return back()->with('success', 'Your message has been sent successfully.');
    }
}

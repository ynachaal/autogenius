<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; // <--- Ensure this is here
use Illuminate\View\View;
use App\Services\EmailService; // <--- Import the Service
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }
    public function index(): View
    {
        return view('front.lead.index');
    }

    /**
     * Handles both the initial "Continue" from Step 1 
     * and the Final Form Submission.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validate incoming data (basic fields + Turnstile)
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|min:10',
            'city' => 'required|string',
          'cf-turnstile-response' => 'required',
        ], [
           'cf-turnstile-response.required' => 'Please complete the security check.',
        ]);

        // 2. Verify Turnstile (5s timeout)
        try {
            $turnstile = Http::asForm()
                ->timeout(5)
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => config('services.turnstile.secret_key'),
                    'response' => $request->input('cf-turnstile-response'),
                    'remoteip' => $request->ip(),
                ]);
        } catch (\Exception $e) {
            \Log::error('Lead Turnstile Error: ' . $e->getMessage());
            return back()
                ->with('error', 'Security service temporarily unavailable. Please try again.')
                ->withInput();
        }

        if (!$turnstile->json('success')) {
            return back()
                ->withErrors(['cf-turnstile-response' => 'Captcha verification failed. Please try again.'])
                ->withInput();
        } 

        // 3. Map data
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
        ];

        // 4. Save to Database (update if same mobile)
        $lead = Lead::create($data);

        // 5. Trigger Emails ONLY on final submission
        if ($request->has('confirm')) {
            // $this->emailService->sendLeadUserConfirmation($lead);
             $this->emailService->sendLeadAdminNotification($lead);
        }

        return redirect()->route('lead.thank-you');
    }
    public function thankYou()
    {
        return view('front.lead.thank-you');
    }
}
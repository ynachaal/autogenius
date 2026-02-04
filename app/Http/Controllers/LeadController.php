<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; // <--- Ensure this is here
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
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
        // 1. Validate incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|min:10',
            'city' => 'required|string',
            'confirm' => 'accepted',
        ]);

        // 2. Map HTML input names to Database columns
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

        // 3. Save to Database
        Lead::updateOrCreate(
            ['mobile' => $request->mobile],
            $data
        );

        // 4. Redirect back with a success message
        return redirect()->route('lead.index')->with('success', 'Your car requirements have been submitted successfully!');
    }
}
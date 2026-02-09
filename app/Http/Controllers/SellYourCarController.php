<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellYourCar;
use Illuminate\Support\Facades\Storage;
use App\Services\EmailService;

class SellYourCarController extends Controller
{
    protected EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function store(Request $request)
    {
        // 1. Validate the incoming data
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
        ]);

        // 2. Handle file upload
        if ($request->hasFile('car_photos')) {
            $path = $request->file('car_photos')->store('cars', 'public');
            $validated['car_photos'] = $path;
        }

        // 3. Save to DB
        $sellYourCar = SellYourCar::create($validated);

        // 4. Send Admin Email ( this is the new part)
        $this->emailService->sellYourCarAdminNotification($sellYourCar);

        // 5. Redirect
        return back()->with('success', 'Thanks! Your request to sell your car has been submitted.');
    }
}

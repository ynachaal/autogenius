<?php

namespace App\Http\Controllers;
use App\Services\EmailService;
use Illuminate\Http\Request;
use App\Models\ContactSubmission;

class ContactSubmissionController extends Controller
{

    protected EmailService $emailService;

     public function __construct(
        EmailService $emailService,
    ) {
        $this->emailService = $emailService;
    }
    /**
     * Show contact form
     */
    public function create()
    {
        return view('front.contact-us');
    }

    /**
     * Store contact submission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string',
        ]);

         $this->emailService->contactUs((object) $validated);

        ContactSubmission::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Your message has been sent successfully.');
    }
}

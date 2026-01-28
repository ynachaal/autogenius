<?php

namespace App\Http\Controllers;
use App\Services\EmailService;
use Illuminate\Http\Request;
use App\Models\ContactSubmission;
use App\Services\PageService;

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
        return view('front.contact-us',compact('page'));
    }

    /**
     * Store contact submission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'mobile_no' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        $this->emailService->contactUs((object) $validated);

        ContactSubmission::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Your message has been sent successfully.');
    }
}

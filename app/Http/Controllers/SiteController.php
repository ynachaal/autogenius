<?php

namespace App\Http\Controllers;

use App\Services\PropertyService;
use App\Services\PropertyAreaService;
use App\Services\ContentMetaService; // Import the service
use App\Services\BlogService;
use App\Services\DeveloperPartnerService;
use App\Services\WhyChooseUsService;
use App\Services\EmailService;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Artisan;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;

class SiteController extends Controller
{
    protected EmailService $emailService;
    protected ContentMetaService $metaService;

    public function __construct(
        EmailService $emailService,
        ContentMetaService $metaService // Inject the service
    ) {
        $this->emailService = $emailService;
        $this->metaService = $metaService;
    }

    public function index(): View
    {
        $data = [
        'trusted_experts'    => $this->metaService->getAllValues('trusted-car-expert'),
        'how_it_works'       => $this->metaService->getAllValues('how-autogenius-works'),
        'service_area'       => $this->metaService->getAllValues('service-area'),
        'why_choose'         => $this->metaService->getAllValues('why-choose-autogenius'),
        'protecting_buyers'  => $this->metaService->getAllValues('protecting-buyers'),
        'about'              => $this->metaService->getAllValues('about-autogenius'),
        'why_founded'        => $this->metaService->getAllValues('why-we-founded-autogenius'),
     ];
        return view('front.home', compact('data'));
    }

    public function queue()
    {
        Artisan::call('queue:work --stop-when-empty');
        return redirect()->route('admin.dashboard')->with('success', 'Migration completed.');
    }

    public function contactUs(Request $request): RedirectResponse|View
    {
        if ($request->isMethod('get')) {
            return view('front.contact-us');
        }

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            $contact = ContactSubmission::create($validated);
            if ($contact) {
                $this->emailService->contactUs($contact);
            }

            return redirect()
                ->back()
                ->with('success', 'Thank you for your message! We will be in touch shortly.');
        } catch (\Throwable $e) {
            Log::error("Contact form submission error: " . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'There was an issue submitting your request. Please try again.');
        }
    }

}

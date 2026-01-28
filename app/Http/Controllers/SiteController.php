<?php

namespace App\Http\Controllers;


use App\Services\PageService;

use App\Services\ContentMetaService; // Import the service



use App\Services\EmailService;
use App\Services\ServiceService;
use App\Services\BrandService;

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
    protected ServiceService $serviceService;
    protected BrandService $brandService; // Add this
    protected PageService $pageService;

    public function __construct(
        EmailService $emailService,
        ServiceService $serviceService,
        ContentMetaService $metaService,
         PageService $pageService,
        BrandService $brandService // Inject BrandService

    ) {
        $this->emailService = $emailService;
        $this->serviceService = $serviceService;
        $this->metaService = $metaService;
        $this->brandService = $brandService;
         $this->pageService = $pageService;

    }

    public function index(): View
    {
        $data = [
            'trusted_experts' => $this->metaService->getAllValues('trusted-car-expert'),
            'how_it_works' => $this->metaService->getAllValues('how-autogenius-works'),
            'service_area' => $this->metaService->getAllValues('service-area'),
            'why_choose' => $this->metaService->getAllValues('why-choose-autogenius'),
            'protecting_buyers' => $this->metaService->getAllValues('protecting-buyers'),
            'about' => $this->metaService->getAllValues('about-autogenius'),
            'why_founded' => $this->metaService->getAllValues('why-we-founded-autogenius'),
            'services' => $this->serviceService->getFeaturedServices(8),
            'featuredBrands' => $this->brandService->getFeaturedBrands()['brands'],
        ];

        return view('front.home', compact('data'));
    }

    public function carDeliveries(): View
    {
        $page = $this->pageService->getBySlug('car-deliveries');
        return view('front.car-deliveries', compact('page'));
    }

    public function queue()
    {
        Artisan::call('queue:work --stop-when-empty');
        return redirect()->route('admin.dashboard')->with('success', 'Migration completed.');
    }

    public function services(): View
    {
        $page = $this->pageService->getBySlug('services');
        $data = [
            'services' => $this->serviceService->getPaginatedServices(12),
        ];
        return view('front.services.index', compact('data','page'));
    }

    public function serviceDetail(string $slug): View
    {
        $service = $this->serviceService->getBySlug($slug);

        if (!$service) {
            abort(404);
        }

        $data = [
            'service' => $service,
        ];

        return view('front.services.show', compact('data'));
    }

    public function pageDetail(string $slug): View
    {
        $page = $this->pageService->getBySlug($slug);

        if (!$page) {
            abort(404);
        }

        return view('front.pages.show', compact('page'));
    }

    public function contactUs(Request $request): RedirectResponse|View
    {
        $page = $this->pageService->getBySlug('contact-us');
        if ($request->isMethod('get')) {
            return view('front.contact-us', compact('page'));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
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

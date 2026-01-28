<?php

namespace App\Http\Controllers;


use App\Services\PageService;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\ContentMetaService; // Import the service
use App\Services\SearchService; // 1. Import the Service
use App\Services\EmailService;
use App\Services\ServiceService;
use App\Services\BrandService;

use Illuminate\Support\Facades\Artisan;
use App\Models\Consultation; // <-- 1. Import the Consultation Model
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
    protected SearchService $searchService; // 2. Add property

    public function __construct(
        EmailService $emailService,
        ServiceService $serviceService,
        ContentMetaService $metaService,
        PageService $pageService,
        SearchService $searchService,
        BrandService $brandService // Inject BrandService

    ) {
        $this->emailService = $emailService;
        $this->serviceService = $serviceService;
        $this->metaService = $metaService;
        $this->brandService = $brandService;
        $this->pageService = $pageService;
        $this->searchService = $searchService; // 4. Assign

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
        return view('front.services.index', compact('data', 'page'));
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

    public function search(Request $request): View
    {
        $validated = $request->validate([
            'q' => 'required|string|min:2',
        ]);

        $query = trim($validated['q']);
        $results = $this->searchService->globalSearch($query);

        $combinedResults = collect();
        foreach ($results as $type => $items) {
            foreach ($items as $item) {
                $item->result_type = $type;
                $combinedResults->push($item);
            }
        }

        // --- Manual Pagination Logic ---
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentResults = $combinedResults->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedResults = new LengthAwarePaginator(
            $currentResults,
            $combinedResults->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $data = [
            'results' => $paginatedResults, // This is now a paginator object
            'query' => $query,
            'count' => $combinedResults->count()
        ];

        return view('front.search.index', compact('data'));
    }

    public function bookConsultation(): View
    {
        return view('front.book-consultation');
    }
    public function storeConsultation(Request $request): RedirectResponse
    {
        // 2. Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:7|max:20',
            'subject' => 'required|string|max:255',
            'preferred_date' => 'required|date|after_or_equal:today',
            'message' => 'nullable|string|min:10',
        ]);

        try {
            // 3. Add default status
            $validated['status'] = 'pending';
            // 4. Create the record
            Consultation::create($validated);
            // Optional: You can use your EmailService here if you want to notify the admin
            // $this->emailService->sendConsultationNotification($validated);

            return back()->with('success', 'Your consultation request has been submitted successfully! We will contact you shortly.');

        } catch (\Exception $e) {
            Log::error('Consultation Store Error: ' . $e->getMessage());
            return back()->with('error', 'There was an error processing your request. Please try again.')->withInput();
        }
    }
}

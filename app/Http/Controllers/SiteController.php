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
}

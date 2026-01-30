<?php

namespace App\Http\Controllers;

use Razorpay\Api\Api;
use App\Services\PageService;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\ContentMetaService;
use App\Services\SearchService;
use App\Services\EmailService;
use App\Services\ServiceService;
use App\Services\SliderService;
use App\Services\BrandService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;

class SiteController extends Controller
{
    protected EmailService $emailService;
    protected SliderService $sliderService;
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
        SliderService $sliderService,
        BrandService $brandService // Inject BrandService

    ) {
        $this->emailService = $emailService;
        $this->serviceService = $serviceService;
        $this->metaService = $metaService;
        $this->brandService = $brandService;
        $this->pageService = $pageService;
        $this->sliderService = $sliderService; // ✅ assign
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
        $sliders = $this->sliderService
            ->getByCategoryName('About AutoGenius');

        return view('front.home', compact('data', 'sliders'));
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
        $perPage = 12;
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
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:7|max:20',
            'subject' => 'required|string|max:255',
            'preferred_date' => 'required|date|after_or_equal:today',
            'message' => 'nullable|string|min:10',
            'cf-turnstile-response' => 'required',
        ], [
            'cf-turnstile-response.required' => 'Please complete the security check.',
        ]);

        // 🔐 Verify Turnstile
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
            Log::error('Turnstile Connection Error: ' . $e->getMessage());
            return back()->with('error', 'Security service unavailable.')->withInput();
        }

        if (!$turnstile->json('success')) {
            return back()
                ->withErrors(['cf-turnstile-response' => 'Captcha verification failed.'])
                ->withInput();
        }

        try {
            /** 1️⃣ Save consultation (payment pending) */
            $consultation = Consultation::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'preferred_date' => $request->preferred_date,
                'status' => 'pending',
                'amount' => 99,
                'payment_status' => 'pending',
            ]);

            /** 2️⃣ Create Razorpay order */
            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            $order = $api->order->create([
                'receipt' => 'consultation_' . $consultation->id,
                'amount' => 99 * 100, // paise
                'currency' => 'INR',
            ]);

            /** 3️⃣ Save order ID */
            $consultation->update([
                'razorpay_order_id' => $order['id'],
            ]);

            /** 4️⃣ Redirect to Razorpay checkout page */
            return view('front.razorpay-checkout', [
                'order' => $order,
                'consultation' => $consultation,
                'razorpayKey' => config('services.razorpay.key'),
            ]);

        } catch (\Exception $e) {
            Log::error('Consultation Store Error: ' . $e->getMessage());

            return back()
                ->with('error', 'Unable to initiate payment. Please try again.')
                ->withInput();
        }
    }
}

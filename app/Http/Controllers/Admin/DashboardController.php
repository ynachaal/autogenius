<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BrandService;
use App\Services\ServiceService;
use App\Services\LeadService;
use App\Services\DashboardStatsService; // Import your new service
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    protected $brandService;
    protected $serviceService;
    protected $leadService;
    protected $statsService; // Add property

    public function __construct(
        BrandService $brandService, 
        ServiceService $serviceService,
        LeadService $leadService,
        DashboardStatsService $statsService // Inject here
    ) {
        $this->brandService = $brandService;
        $this->serviceService = $serviceService;
        $this->leadService = $leadService;
        $this->statsService = $statsService;
    }

    public function index()
    {
        // Get the detailed counts from your new service
        $detailedStats = $this->statsService->getStats();

        $stats = [
            'active_brands'   => $this->brandService->getActiveBrandsCount(),
            'active_services' => $this->serviceService->getActiveServicesCount(),
            'total_leads'     => $this->leadService->getTotalLeadsCount(),
            
            // Merge the new detailed stats
            'consultations'    => $detailedStats['consultations'],
            'inspections'      => $detailedStats['inspections'],
            'insurance_claims' => $detailedStats['insurance_claims'],
            'car_sales'        => $detailedStats['car_sales'],
        ];

        return view('admin.dashboard', compact('stats'));
    }
    public function migrate()
    {
        Artisan::call('migrate');
        return redirect()->route('admin.dashboard')->with('success', 'Migration completed.');
    }
    public function clearCache()
    {
        Artisan::call('optimize:clear');
        return redirect()->route('admin.dashboard')->with('success', 'Application cache cleared successfully.');
    }

    public function storageLink()
    {
        Artisan::call('storage:link');

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Storage link created successfully.');
    }
}

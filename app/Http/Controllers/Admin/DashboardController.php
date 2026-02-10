<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\BrandService;
use App\Services\ServiceService;
use App\Services\LeadService;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    protected $brandService;
    protected $serviceService;
    protected $leadService;
    protected $consultationService;

    public function __construct(
        BrandService $brandService, 
        ServiceService $serviceService,
        LeadService $leadService,
       
    ) {
        $this->brandService = $brandService;
        $this->serviceService = $serviceService;
        $this->leadService = $leadService;
      
    }

    public function index()
    {
        $stats = [
            'active_brands'   => $this->brandService->getActiveBrandsCount(),
            'active_services' => $this->serviceService->getActiveServicesCount(),
            'total_leads'     => $this->leadService->getTotalLeadsCount(),
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

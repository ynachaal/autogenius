<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Models\UnittypeAssignedWorkflow;
use Illuminate\Support\Facades\Artisan;
use App\Models\ApplicationAssignedWorkflow;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Consultation;
use App\Models\Brand;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [

            // Brands where status is 'active' (per your model defaults)
            'active_brands' => Brand::where('status', 'active')->count(),

            // Services using the active scope (status is true)
            'active_services' => Service::active()->count(),

            // Total Users (Non-Admins)
            'total_users' => User::where('role', '02')->count(),

            'total_consultations' => Consultation::count(),
            'pending_consultations' => Consultation::where('status', 'pending')->count(),
            'completed_consultations' => Consultation::where('status', 'completed')->count(),
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

<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Models\UnittypeAssignedWorkflow;
use Illuminate\Support\Facades\Artisan;
use App\Models\ApplicationAssignedWorkflow;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardController extends Controller
{

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


}

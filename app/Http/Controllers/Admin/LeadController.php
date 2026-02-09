<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $usage = $request->input('usage'); 

        $query = Lead::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($usage) {
            $query->where('primary_usage', $usage);
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        
        $submissions = $query->orderBy($sortBy, $sortDirection)->paginate(15);
        
        return view('admin.leads.index', compact('submissions', 'search', 'usage'));
    }

    public function show(Lead $lead)
    {
          $lead->load('payments');
         return view('admin.leads.show', compact('lead'));
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('success', 'Lead deleted.');
    }
}
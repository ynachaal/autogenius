<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellYourCar;
use Illuminate\Http\Request;

class SellYourCarController extends Controller
{
    /**
     * Display a listing of the car sale inquiries.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = SellYourCar::query();

        // ---------- SEARCH ----------
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('vehicle_name', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_mobile', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        // ---------- SORTING ----------
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $allowedSorts = ['id', 'vehicle_name', 'year', 'customer_name', 'created_at'];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortDirection);

        // ---------- PAGINATION ----------
        $inquiries = $query->paginate(15);
        $inquiries->appends([
            'search' => $search,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ]);

        return view('admin.sell-your-cars.index', compact(
            'inquiries',
            'sortBy',
            'sortDirection',
            'search'
        ));
    }

    /**
     * Display the specific car inquiry details.
     */
    public function show(SellYourCar $sellYourCar)
    {
      
        return view('admin.sell-your-cars.show', compact('sellYourCar'));
    }

    /**
     * Remove the inquiry.
     */
    public function destroy(SellYourCar $sellYourCar)
    {
        $sellYourCar->delete();

        return redirect()->route('admin.sell-your-cars.index')
                         ->with('success', 'Inquiry deleted successfully!');
    }
}
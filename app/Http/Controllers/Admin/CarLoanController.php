<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarLoan;
use Illuminate\Http\Request;

class CarLoanController extends Controller
{
    /**
     * Display a listing of the car loan applications.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = CarLoan::query();

        // ---------- SEARCH ----------
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_mobile', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('loan_type', 'like', "%{$search}%");
            });
        }

        // ---------- SORTING ----------
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $allowedSorts = ['id', 'customer_name', 'loan_type', 'city', 'status', 'created_at'];

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

        return view('admin.car-loans.index', compact(
            'inquiries',
            'sortBy',
            'sortDirection',
            'search'
        ));
    }

    /**
     * Display the specific car loan details.
     */
    public function show(CarLoan $carLoan)
    {
        return view('admin.car-loans.show', compact('carLoan'));
    }

    /**
     * Remove the loan application.
     */
    public function destroy(CarLoan $carLoan)
    {
        $carLoan->delete();

        return redirect()->route('admin.car-loans.index')
                         ->with('success', 'Loan application deleted successfully!');
    }
}
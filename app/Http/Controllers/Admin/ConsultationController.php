<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the consultations.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status'); // e.g., 'pending', 'completed', etc.

        $query = Consultation::query();

        // ---------- SEARCH ----------
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // ---------- STATUS FILTER ----------
        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        // ---------- SORTING ----------
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $allowedSorts = ['id', 'name', 'email', 'status', 'preferred_date', 'created_at'];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortDirection);

        // ---------- PAGINATION ----------
        $consultations = $query->paginate(15);
        $consultations->appends([
            'search' => $search,
            'status' => $status,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ]);

        return view('admin.consultations.index', compact(
            'consultations',
            'sortBy',
            'sortDirection',
            'search',
            'status'
        ));
    }

    /**
     * Display the specified consultation.
     */
    public function show(Consultation $consultation)
    {
        return view('admin.consultations.show', compact('consultation'));
    }

    /**
     * Update the status of the consultation.
     */
    public function updateStatus(Request $request, Consultation $consultation)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $consultation->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Consultation status updated successfully!');
    }

    /**
     * Remove the specified consultation.
     */
    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('admin.consultations.index')
                         ->with('success', 'Consultation deleted successfully!');
    }
}
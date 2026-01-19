<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;

use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    /**
     * Display a listing of the submissions.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status'); // 1 = read, 0 = unread

        $query = ContactSubmission::query();

        // ---------- SEARCH ----------
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // ---------- STATUS FILTER ----------
        if ($status !== null && in_array($status, ['0', '1'])) {
            $query->where('is_read', $status);
        }

        // ---------- SORTING ----------
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $allowedSorts = ['id', 'name', 'email', 'is_read', 'created_at'];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortDirection);

        // ---------- PAGINATION ----------
        $submissions = $query->paginate(15);
        $submissions->appends([
            'search' => $search,
            'status' => $status,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ]);

        return view('admin.contact-submissions.index', compact(
            'submissions',
            'sortBy',
            'sortDirection',
            'search',
            'status'
        ));
    }

    /**
     * Display the specified submission and mark as read.
     */
    public function show(ContactSubmission $contactSubmission)
    {
        // Automatically mark as read when viewed
        if (!$contactSubmission->is_read) {
            $contactSubmission->update(['is_read' => true]);
        }

        return view('admin.contact-submissions.show', compact('contactSubmission'));
    }

    /**
     * Toggle the read status (useful for bulk actions or quick clicks).
     */
    public function toggleRead(ContactSubmission $contactSubmission)
    {
        $contactSubmission->update([
            'is_read' => !$contactSubmission->is_read
        ]);

        return back()->with('success', 'Status updated successfully!');
    }

    /**
     * Remove the specified submission (Soft Delete).
     */
    public function destroy(ContactSubmission $contactSubmission)
    {
        $contactSubmission->delete();

        return redirect()->route('admin.contact-submissions.index')
                         ->with('success', 'Submission deleted successfully!');
    }
}
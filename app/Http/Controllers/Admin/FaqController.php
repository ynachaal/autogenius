<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Get search and sort parameters from the request
        $query = $request->input('q');
        // Default sort by 'order' since it's the primary display setting
        $sortBy = $request->input('sort_by', 'id'); 
        $sortDirection = $request->input('sort_direction', 'asc'); 

        // 2. Build the query
        $faqs = Faq::query();

        // Apply search filter if a query is present
        if ($query) {
            $faqs->where('question', 'LIKE', "%$query%")
                 ->orWhere('answer', 'LIKE', "%$query%");
        }

        // Apply sorting based on user input
        if (in_array($sortBy, ['id', 'question', 'order', 'is_active', 'created_at'])) {
            $faqs->orderBy($sortBy, $sortDirection);
        }

        // Always order by 'order' and then 'id' as a fallback to ensure stability
        $faqs->orderBy('order', 'asc')->orderBy('id', 'asc');

        // 3. Paginate the results and preserve search/sort parameters
        $faqs = $faqs->paginate(10)->withQueryString();

        return view('admin.faqs.index', compact('faqs', 'query', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Calculate the next order number to pre-fill the form
        $nextOrder = Faq::max('order') + 1;
        return view('admin.faqs.create', compact('nextOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            // Ensure order is a positive integer
            'order' => 'required|integer|min:1', 
            'is_active' => 'nullable|boolean',
        ]);

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        // For FAQ, this view is typically simple, but included for completeness
        return view('admin.faqs.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully.');
    }
}

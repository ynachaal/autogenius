<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status'); // 1 = active, 0 = inactive

        $query = Testimonial::query();

        // ---------- SEARCH ----------
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('designation', 'like', "%{$search}%") // Add this line
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // ---------- STATUS FILTER ----------
        if ($status !== null && in_array($status, ['0', '1'])) {
            $query->where('status', $status);
        }

        // ---------- SORTING ----------
        $sortBy = $request->input('sort_by', 'order');
        $sortDirection = $request->input('sort_direction', 'asc');
        $allowedSorts = ['id', 'title', 'order', 'status', 'created_at'];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'order';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortDirection);

        // ---------- PAGINATION ----------
        $testimonials = $query->paginate(10);
        $testimonials->appends([
            'search' => $search,
            'status' => $status,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ]);

        return view('admin.testimonials.index', compact(
            'testimonials',
            'sortBy',
            'sortDirection',
            'search',
            'status'
        ));
    }

    /**
     * Show the form for creating a new testimonial.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created testimonial in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'designation' => ['nullable', 'string', 'max:200'], // Add this line
        'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        'youtube_url' => ['nullable', 'url', 'max:255'],
        'order' => ['nullable', 'integer'],
        'status' => ['nullable', 'boolean'], // Changed to nullable
    ]);

    // Force status to be 0 or 1
    $validatedData['status'] = $request->has('status') ? 1 : 0;

    if ($request->hasFile('image')) {
        $validatedData['image'] = $request->file('image')->store('testimonials', 'public');
    }

    Testimonial::create($validatedData);

    return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully!');
}

    /**
     * Display the specified testimonial.
     */
    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified testimonial.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial in storage.
     */
   public function update(Request $request, Testimonial $testimonial)
{
    $validatedData = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        'youtube_url' => ['nullable', 'url', 'max:255'],
        'designation' => ['nullable', 'string', 'max:200'], // Add this line
        'order' => ['nullable', 'integer'],
        'status' => ['nullable', 'boolean'], // Changed to nullable
    ]);

    // This is the critical line: if the checkbox isn't in the request, set status to 0
    $validatedData['status'] = $request->has('status') ? 1 : 0;

    if ($request->hasFile('image')) {
        if ($testimonial->image) {
            Storage::disk('public')->delete($testimonial->image);
        }
        $validatedData['image'] = $request->file('image')->store('testimonials', 'public');
    }

    $testimonial->update($validatedData);

    return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully!');
}

    /**
     * Remove the specified testimonial from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image) {
            Storage::disk('public')->delete($testimonial->image);
        }
        
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully!');
    }
}
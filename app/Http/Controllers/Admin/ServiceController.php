<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');       // 1 = active, 0 = inactive
        $featured = $request->input('featured');   // 1 = featured, 0 = not featured

        $query = Service::query();

        // ---------- SEARCH ----------
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('sub_heading', 'like', "%{$search}%");
            });
        }

        // ---------- STATUS FILTER ----------
        if ($status !== null && in_array($status, ['0', '1'])) {
            $query->where('status', $status);
        }

        // ---------- FEATURED FILTER ----------
        if ($featured !== null && in_array($featured, ['0', '1'])) {
            $query->where('featured', $featured);
        }

        // ---------- SORTING ----------
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $allowedSorts = ['id', 'title', 'slug', 'status', 'featured', 'created_at'];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortDirection);

        // ---------- PAGINATION ----------
        $services = $query->paginate(10);
        $services->appends([
            'search' => $search,
            'status' => $status,
            'featured' => $featured,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ]);

        return view('admin.services.index', compact(
            'services',
            'sortBy',
            'sortDirection',
            'search',
            'status',
            'featured'
        ));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                // Validate uniqueness against non-deleted records for clean UI feedback
                Rule::unique('services', 'slug')->whereNull('deleted_at')
            ],
            'sub_heading' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'status' => ['boolean'],
            'featured' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:100'],
        'meta_description' => ['nullable', 'string', 'max:500'],
        'meta_keywords' => ['nullable', 'string', 'max:500'],
        ]);

        // --- SLUG GENERATION AND UNIQUENESS CHECK (STORE) ---
        // If slug is empty, generate from title. If provided, format it.
        $slugBase = !empty($validatedData['slug']) ? $validatedData['slug'] : $validatedData['title'];
        $slug = Str::slug($slugBase);
        $originalSlug = $slug;

        // Loop to ensure slug is unique even against trashed items (prevents DB crash)
        $count = 1;
        while (Service::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $validatedData['slug'] = $slug;

        // Handle image upload
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('services', 'public');
        }

        $data = $validatedData + [
            'status' => $request->has('status') ? 1 : 0,
            'featured' => $request->has('featured') ? 1 : 0,
        ];

        $service = Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully!');
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')
                    ->ignore($service->id)
                    ->whereNull('deleted_at'),
            ],
            'sub_heading' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'status' => ['boolean'],
            'featured' => ['boolean'],
            'remove_image' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:100'],
        'meta_description' => ['nullable', 'string', 'max:500'],
        'meta_keywords' => ['nullable', 'string', 'max:500'],
        ]);

        // --- SLUG GENERATION AND UNIQUENESS CHECK (UPDATE) ---
        // Only regenerate if slug field is cleared or if title changed and slug was originally auto-generated
        if (empty($validatedData['slug'])) {
            $slug = Str::slug($validatedData['title']);
            $originalSlug = $slug;
            
            $count = 1;
            // Check against ALL records (including trashed) except the current one
            while (Service::withTrashed()
                ->where('slug', $slug)
                ->where('id', '!=', $service->id)
                ->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $validatedData['slug'] = $slug;
        } else {
            // Format manually entered slug
            $validatedData['slug'] = Str::slug($validatedData['slug']);
        }

        // Image removal
        if ($request->boolean('remove_image') && $service->image) {
            Storage::disk('public')->delete($service->image);
            $service->image = null;
        }

        // Handle New Image Upload
        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validatedData['image'] = $request->file('image')->store('services', 'public');
        } else {
            if (!$request->boolean('remove_image')) {
                // Keep the existing image if we aren't uploading a new one or removing it
                $validatedData['image'] = $service->image;
            } else {
                $validatedData['image'] = null;
            }
        }

        unset($validatedData['remove_image']);

        $data = $validatedData + [
            'status' => $request->has('status') ? 1 : 0,
            'featured' => $request->has('featured') ? 1 : 0,
        ];

        $service->update($data);

        return redirect()
            ->route('admin.services.show', $service)
            ->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        // Note: For Soft Deletes, we usually KEEP the image in case of restoration.
        // If you want to delete the image only on Force Delete, keep this in mind.
        // For now, I'm leaving your original logic but commenting that it deletes the file.
        
        /* if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        */

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service moved to trash!');
    }
}
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
            'title'       => ['required', 'string', 'max:255'],
            'slug'        => [
                'nullable',
                'string',
                'max:255',
               Rule::unique('services', 'slug')->whereNull('deleted_at') // Check uniqueness only against non-deleted
            ],
            'sub_heading' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'status'      => ['boolean'],
            'featured'    => ['boolean'],
        ]);

        // --- SLUG GENERATION AND UNIQUENESS CHECK (STORE) ---
        if (empty($validatedData['slug'])) {
            // 1. Auto-generate slug from the title if blank
            $validatedData['slug'] = Str::slug($validatedData['title']);

            // 2. Ensure generated slug is unique
            $count = 0;
            $originalSlug = $validatedData['slug'];
            while (Service::where('slug', $validatedData['slug'])->exists()) {
                $count++;
                $validatedData['slug'] = $originalSlug . '-' . $count;
            }
        } else {
            // 3. Format manually entered slug
            $validatedData['slug'] = Str::slug($validatedData['slug']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('services', 'public');
        }

        $data = $validatedData + [
            'status'   => $request->has('status') ? 1 : 0,
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
            'title'        => ['required', 'string', 'max:255'],
            'slug'         => [
                'nullable',
                'string',
                'max:255',
               Rule::unique('services', 'slug')
                ->ignore($service->id)
                ->whereNull('deleted_at'),
            ],
            'sub_heading'  => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'image'        => ['nullable', 'image', 'max:2048'],
            'status'       => ['boolean'],
            'featured'     => ['boolean'],
            'remove_image' => ['boolean'],
        ]);

        // --- SLUG GENERATION AND UNIQUENESS CHECK (UPDATE) ---
        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['title']);

            $count = 0;
            $originalSlug = $validatedData['slug'];
            while (Service::where('slug', $validatedData['slug'])->where('id', '!=', $service->id)->exists()) {
                $count++;
                $validatedData['slug'] = $originalSlug . '-' . $count;
            }
        } else {
            $validatedData['slug'] = Str::slug($validatedData['slug']);
        }

        // Image removal
        if ($request->boolean('remove_image') && $service->image) {
            Storage::disk('public')->delete($service->image);
            $service->image = null;
        }

        // New image upload
        // 2. Handle New Image Upload
    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        // Store new image and put the path into the validated array
        $validatedData['image'] = $request->file('image')->store('services', 'public');
    } else {
        // If no new image is uploaded and we aren't removing it, 
        // unset it so we don't overwrite the existing path with null
        if (!$request->boolean('remove_image')) {
            unset($validatedData['image']);
        }
    }

        // Remove helper field from update array
        unset($validatedData['remove_image']);
        
        // Ensure image path is updated correctly if not changed by file upload
        if (!isset($validatedData['image'])) {
            $validatedData['image'] = $service->image;
        }

         $data = $validatedData + [
            'status'   => $request->has('status') ? 1 : 0,
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
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully!');
    }
}
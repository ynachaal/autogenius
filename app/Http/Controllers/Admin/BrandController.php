<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage; // Use Storage instead of File
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use enshrined\svgSanitize\Sanitizer;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status'); // active/inactive
        $is_featured = $request->input('is_featured'); // 1 = featured, 0 = not featured

        $query = Brand::query();

        // ---------- SEARCH ----------
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // ---------- STATUS FILTER ----------
        if ($status !== null && in_array($status, ['active', 'inactive'])) {
            $query->where('status', $status);
        }

        // ---------- FEATURED FILTER ----------
        if ($is_featured !== null && in_array($is_featured, ['0', '1'])) {
            $query->where('is_featured', $is_featured);
        }

        // ---------- SORTING ----------
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $allowedSorts = ['id', 'name', 'slug', 'status', 'is_featured', 'order', 'created_at'];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortDirection);

        // ---------- PAGINATION ----------
        $brands = $query->paginate(10);
        $brands->appends([
            'search' => $search,
            'status' => $status,
            'is_featured' => $is_featured,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ]);

        return view('admin.brands.index', compact(
            'brands',
            'sortBy',
            'sortDirection',
            'search',
            'status',
            'is_featured'
        ));
    }

    /**
     * Show the form for creating a new brand.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created brand in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:191', Rule::unique('brands')->whereNull('deleted_at')],
            'description' => ['nullable', 'string'],
            'status' => ['in:active,inactive'],
            'is_featured' => ['boolean'],
            'order' => ['nullable', 'integer'],
            'meta_title' => ['nullable', 'string', 'max:191'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp', 'max:2048'],
        ]);

        // Slug Generation
        $slug = Str::slug($validatedData['name']);
        $originalSlug = $slug;
        $count = 1;
        while (Brand::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $validatedData['slug'] = $slug;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '_' . $slug . '.' . $extension;
            $storagePath = 'brands/' . $imageName; // Relative path for storage disk

            if ($extension === 'svg') {
                $sanitizer = new Sanitizer();
                $cleanSvg = $sanitizer->sanitize(file_get_contents($image->getRealPath()));
                
                // Storage handles directory creation automatically
                Storage::disk('public')->put($storagePath, $cleanSvg);
            } else {
                // storeAs is the standard way to move files to storage
                $image->storeAs('brands', $imageName, 'public');
            }

            $validatedData['image'] = $storagePath;
        }

        Brand::create($validatedData);

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully!');
    }

    /**
     * Display the specified brand.
     */
    public function show(Brand $brand)
    {
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified brand.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified brand in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:191', Rule::unique('brands', 'name')->ignore($brand->id)->whereNull('deleted_at')],
            'description' => ['nullable', 'string'],
            'status' => ['in:active,inactive'],
            'is_featured' => ['boolean'],
            'order' => ['nullable', 'integer'],
            'meta_title' => ['nullable', 'string', 'max:191'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp', 'max:2048'],
        ]);

        // Update Slug if name changed
        if ($brand->name !== $validatedData['name']) {
            $slug = Str::slug($validatedData['name']);
            $originalSlug = $slug;
            $count = 1;
            while (Brand::withTrashed()->where('slug', $slug)->where('id', '!=', $brand->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $validatedData['slug'] = $slug;
        }

        if ($request->hasFile('image')) {
            // Delete old image using Storage facade
            if ($brand->image && Storage::disk('public')->exists($brand->image)) {
                Storage::disk('public')->delete($brand->image);
            }

            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            // Use current slug (either new or existing)
            $currentSlug = $validatedData['slug'] ?? $brand->slug;
            $imageName = time() . '_' . $currentSlug . '.' . $extension;
            $storagePath = 'brands/' . $imageName;

            if ($extension === 'svg') {
                $sanitizer = new Sanitizer();
                $cleanSvg = $sanitizer->sanitize(file_get_contents($image->getRealPath()));
                Storage::disk('public')->put($storagePath, $cleanSvg);
            } else {
                $image->storeAs('brands', $imageName, 'public');
            }

            $validatedData['image'] = $storagePath;
        }

        $brand->update($validatedData);

        return redirect()->route('admin.brands.show', $brand)->with('success', 'Brand updated successfully!');
    }

    /**
     * Remove the specified brand from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand moved to trash!');
    }
}
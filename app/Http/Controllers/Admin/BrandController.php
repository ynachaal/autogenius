<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
            'name' => ['required', 'string', 'max:191', 'unique:brands,name'],
            'description' => ['nullable', 'string'],
            'status' => ['in:active,inactive'],
            'is_featured' => ['boolean'],
            'order' => ['nullable', 'integer'],
            'meta_title' => ['nullable', 'string', 'max:191'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'image' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,gif,svg',
                'max:2048',
            ],
        ]);

        // Generate unique slug
        $validatedData['slug'] = Str::slug($validatedData['name']);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validatedData['name']) . '.' . $image->getClientOriginalExtension();

            // Move to public/uploads/brands
            $image->move(public_path('uploads/brands'), $imageName);
            $validatedData['image'] = 'uploads/brands/' . $imageName;
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
            'name' => ['required', 'string', 'max:191', 'unique:brands,name,' . $brand->id],
            'description' => ['nullable', 'string'],
            'status' => ['in:active,inactive'],
            'is_featured' => ['boolean'],
            'order' => ['nullable', 'integer'],
            'meta_title' => ['nullable', 'string', 'max:191'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'image' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,gif,svg',
                'max:2048',
            ],

        ]);

        // Update slug if name changed
        if ($brand->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        // Handle Image Update
        if ($request->hasFile('image')) {
            // 1. Delete old image if it exists
            if ($brand->image && File::exists(public_path($brand->image))) {
                File::delete(public_path($brand->image));
            }

            // 2. Upload new image
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validatedData['name']) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/brands'), $imageName);
            $validatedData['image'] = 'uploads/brands/' . $imageName;
        } else {
            // Keep existing image if no new file is uploaded
            $validatedData['image'] = $brand->image;
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

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully!');
    }
}

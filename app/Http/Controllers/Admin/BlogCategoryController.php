<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start query
        $query = BlogCategory::query();

       

        // 1. Search filtering
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
        }

        // 2. Sorting
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $allowedSorts = ['id', 'name', 'slug', 'created_at'];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        // 3. Fetch paginated results
        $categories = $query->orderBy($sortBy, $sortDirection)->paginate(10);

        // Return to view
        return view('admin.blog-categories.index', compact('categories', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.blog-categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        // Validate inputs
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:blog-categories,name'],
            'description' => ['nullable', 'string'],
        ]);

        // Generate slug
        $validatedData['slug'] = Str::slug($validatedData['name']);

        // Create category
        BlogCategory::create($validatedData);

        // Redirect
        return redirect()->route('admin.blog-categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified category.
     */
    public function show(BlogCategory $blogCategory)
    {
        return view('admin.blog-categories.show', compact('blogCategory'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog-categories.edit', compact('blogCategory'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        // Validate inputs
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:blog-categories,name,' . $blogCategory->id],
            'description' => ['nullable', 'string'],
        ]);

        // Update slug
        $validatedData['slug'] = Str::slug($validatedData['name']);

        // Update category
        $blogCategory->update($validatedData);

        return redirect()->route('admin.blog-categories.show', $blogCategory)
                         ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        return redirect()->route('admin.blog-categories.index')->with('success', 'Category deleted successfully!');
    }
}

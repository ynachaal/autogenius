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
        $search = $request->input('search');
        $blogs_count = $request->input('blogs_count'); // 1 = has blogs, 0 = no blogs
        $is_active = $request->input('is_active'); // 1 = active, 0 = inactive

        $query = BlogCategory::query()->withCount('blogs');

        // ---------- SEARCH ----------
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // ---------- BLOGS COUNT FILTER ----------
        if ($blogs_count !== null && in_array($blogs_count, ['0', '1'])) {
            $query->having('blogs_count', $blogs_count === '1' ? '>' : '=', 0);
        }

        // ---------- IS_ACTIVE FILTER ----------
        if ($is_active !== null && in_array($is_active, ['0', '1'])) {
            $query->where('is_active', $is_active);
        }

        // ---------- SORTING ----------
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $allowedSorts = ['id', 'name', 'slug', 'is_active', 'created_at'];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortDirection);

        // ---------- PAGINATION ----------
        $categories = $query->paginate(10);
        $categories->appends([
            'search' => $search,
            'blogs_count' => $blogs_count,
            'is_active' => $is_active,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ]);

        return view('admin.blog-categories.index', compact(
            'categories',
            'sortBy',
            'sortDirection',
            'search',
            'blogs_count',
            'is_active'
        ));
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
            'name' => ['required', 'string', 'max:255', 'unique:blog_categories,name'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
               'meta_title' => ['nullable', 'string', 'max:255'],
        'meta_description' => ['nullable', 'string'],
        'meta_keywords' => ['nullable', 'string'],
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
        $blogCategory->loadCount('blogs');
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
            'name' => ['required', 'string', 'max:255', 'unique:blog_categories,name,' . $blogCategory->id],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
                 'meta_title' => ['nullable', 'string', 'max:255'],
        'meta_description' => ['nullable', 'string'],
        'meta_keywords' => ['nullable', 'string'],
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
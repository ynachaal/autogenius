<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory; // <-- ADDED
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Blog::with('author', 'category');

    // 1. Search Filtering
    if ($request->filled('search')) {
        $search = $request->input('search');

        $query->where(function($q) use ($search) {
            // Search by blog title
            $q->where('title', 'like', "%{$search}%")
              // Search by author name
              ->orWhereHas('author', function ($q2) use ($search) {
                  $q2->where('name', 'like', "%{$search}%");
              })
              // Search by category name
              ->orWhereHas('category', function ($q3) use ($search) {
                  $q3->where('name', 'like', "%{$search}%");
              });
        });
    }

    // 2. Sorting
    $sortBy = $request->input('sort_by', 'id');
    $sortDirection = $request->input('sort_direction', 'asc');

    $allowedSorts = ['id', 'title', 'created_at'];
    if (!in_array($sortBy, $allowedSorts)) {
        $sortBy = 'created_at';
    }
    $sortDirection = (strtolower($sortDirection) === 'asc') ? 'asc' : 'desc';

    $blogs = $query->orderBy($sortBy, $sortDirection)->paginate(10);

    return view('admin.blogs.index', compact('blogs', 'sortBy', 'sortDirection'));
}
    // ---

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // FETCH CATEGORIES: Fetch all categories to populate the dropdown
        $categories = BlogCategory::all(); 

        return view('admin.blogs.create', compact('categories')); // <-- PASS CATEGORIES
    }

    // ---

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:blogs,title'], 
            'category_id' => ['required', 'exists:blog_categories,id'], // <-- ADDED VALIDATION
            'content' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'], 
        ]);

        // 2. Add the author_id from the currently authenticated user
        $validatedData['author_id'] = Auth::id();

        // 3. Create the Blog post (Slug is generated in the model's booted method)
        // category_id is automatically included in $validatedData and saved to the blog post.
        $blog = Blog::create($validatedData);

        // 4. Redirect
        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully!');
    }

    // ---

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        // Load the author relationship
        $blog->load('author');
        
        return view('admin.blogs.show', compact('blog'));
    }

    // ---

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        // Simple Authorization Check (ensure the current user is the author)
        if (Auth::id() !== $blog->author_id) {
            abort(403, 'Unauthorized action. You can only edit your own posts.');
        }
        
        // Fetch categories for the edit view as well
        $categories = BlogCategory::all(); 

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    // ---

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        // Simple Authorization Check
        if (Auth::id() !== $blog->author_id) {
            abort(403, 'Unauthorized action. You can only update your own posts.');
        }
        
        // 1. Validation
        $validatedData = $request->validate([
            // Ignore the current blog's ID for the unique title check
            'title' => ['required', 'string', 'max:255', 'unique:blogs,title,' . $blog->id], 
            'category_id' => ['required', 'exists:blog_categories,id'], // <-- ADDED VALIDATION
            'content' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        // 2. Update the Blog post (Slug is regenerated in the model's booted method)
        $blog->update($validatedData);

        // 3. Redirect
        return redirect()->route('admin.blogs.show', $blog)->with('success', 'Blog post updated successfully!');
    }

    // ---

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        // Simple Authorization Check
        if (Auth::id() !== $blog->author_id) {
            abort(403, 'Unauthorized action. You can only delete your own posts.');
        }
        
        // 1. Delete the Blog post
        $blog->delete();

        // 2. Redirect
        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully!');
    }
}

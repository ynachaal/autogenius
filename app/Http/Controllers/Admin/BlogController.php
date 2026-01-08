<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; // <-- CRITICAL: Ensure Rule is imported

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $is_published = $request->input('is_published');
        $category_id = $request->input('category_id');

        $blogsQuery = Blog::query()->with(['author', 'category']);

        if ($search) {
            $blogsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhereHas('author', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($is_published !== null && in_array($is_published, ['0', '1'])) {
            $blogsQuery->where('is_published', $is_published);
        }

        if ($category_id !== null && $category_id !== '') {
            $blogsQuery->where('category_id', $category_id);
        }

        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $allowedSorts = ['id', 'title', 'slug', 'author', 'category', 'is_published', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        if ($sortBy === 'author') {
            $blogsQuery->join('users', 'blogs.author_id', '=', 'users.id')
                ->select('blogs.*')
                ->orderBy('users.name', $sortDirection);
        } elseif ($sortBy === 'category') {
            $blogsQuery->leftJoin('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
                ->select('blogs.*')
                ->orderBy('blog_categories.name', $sortDirection);
        } else {
            $blogsQuery->orderBy($sortBy, $sortDirection);
        }

        $blogs = $blogsQuery->paginate(10);
        $blogs->appends(array_merge($request->query(), [
            'search' => $search,
            'is_published' => $is_published,
            'category_id' => $category_id,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection
        ]));

        $categories = BlogCategory::all();

        return view('admin.blogs.index', compact('blogs', 'sortBy', 'sortDirection', 'is_published', 'categories', 'category_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::where('is_active', 1)->get();
        $users = User::all();
        return view('admin.blogs.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blogs', 'slug')->whereNull('deleted_at'),
            ],
            'content' => 'required|string|min:10',
            'author_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:blog_categories,id',
            'is_published' => 'boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // ✅ SEO
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('featured_image')) {
            try {
                $image = $request->file('featured_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/blogs'), $imageName);
                $validated['featured_image'] = 'uploads/blogs/' . $imageName;
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['featured_image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        }

        // --- SLUG GENERATION AND UNIQUENESS CHECK (STORE) ---
        if (empty($validated['slug'])) {
            // 1. Auto-generate slug from the title if blank
            $validated['slug'] = Str::slug($validated['title']);

            // 2. Ensure generated slug is unique
            $count = 0;
            $originalSlug = $validated['slug'];
            // Check for uniqueness across all existing blogs
            while (Blog::where('slug', $validated['slug'])->exists()) {
                $count++;
                $validated['slug'] = $originalSlug . '-' . $count;
            }
        } else {
            // 3. Format and validate manually entered slug
            $validated['slug'] = Str::slug($validated['slug']);

            // NOTE: The unique check for a manually entered slug is primarily handled
            // by the Rule::unique validator at the beginning of the method.
            // If validation passes, we don't need to check uniqueness here.
        }
        // --- END SLUG LOGIC ---

        $blog = Blog::create($validated);

        return redirect()->route('admin.blogs.show', $blog)->with('success', 'Blog created successfully: ' . $validated['title']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blog->load(['author', 'category']);
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $categories = BlogCategory::all();
        $users = User::all();
        return view('admin.blogs.edit', compact('blog', 'categories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blogs', 'slug')
                    ->whereNull('deleted_at')
                    ->ignore($blog->id),
            ],
            'content' => 'required|string|min:10',
            'author_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:blog_categories,id',
            'is_published' => 'boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // ✅ SEO
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('featured_image')) {
            try {
                if ($blog->featured_image && file_exists(public_path($blog->featured_image))) {
                    unlink(public_path($blog->featured_image));
                }
                $image = $request->file('featured_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/blogs'), $imageName);
                $validated['featured_image'] = 'uploads/blogs/' . $imageName;
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['featured_image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        } else {
            $validated['featured_image'] = $blog->featured_image;
        }

        // --- SLUG GENERATION AND UNIQUENESS CHECK (UPDATE) ---
        if (empty($validated['slug'])) {
            // 1. Auto-generate slug from the title if blank
            $validated['slug'] = Str::slug($validated['title']);

            // 2. Uniqueness check for generated slug, ignoring the current blog
            $count = 0;
            $originalSlug = $validated['slug'];
            while (Blog::where('slug', $validated['slug'])->where('id', '!=', $blog->id)->exists()) {
                $count++;
                $validated['slug'] = $originalSlug . '-' . $count;
            }
        } else {
            // 3. Format and validate manually entered slug
            $validated['slug'] = Str::slug($validated['slug']);
            // Uniqueness is checked by Rule::unique above
        }
        // --- END SLUG LOGIC ---


        $validated['is_published'] = isset($validated['is_published']) ? 1 : 0;

        $blog->update($validated);

        return redirect()->route('admin.blogs.show', $blog)->with('success', 'Blog updated successfully: ' . $blog->title);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        try {
            if ($blog->featured_image && file_exists(public_path($blog->featured_image))) {
                unlink(public_path($blog->featured_image));
            }
            $blog->delete();
            return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully: ' . $blog->title);
        } catch (\Exception $e) {
            return redirect()->route('admin.blogs.index')->with('error', 'Failed to delete blog: ' . $e->getMessage());
        }
    }
}
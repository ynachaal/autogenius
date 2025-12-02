<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');

        // Start building the query
        $pagesQuery = Page::query();

        // Apply search filter if a query is present
        if ($query) {
            $pagesQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('slug', 'like', '%' . $query . '%');
            });
        }

        // --- Sorting ---
        $sortBy = $request->input('sort_by', 'id'); // default sort
        $sortDirection = $request->input('sort_direction', 'asc');

        // Allowed columns to sort by
        $allowedSorts = ['id', 'title', 'slug', 'is_published', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'asc';

        // Apply sorting
        $pagesQuery->orderBy($sortBy, $sortDirection);

        // --- Pagination ---
        $pages = $pagesQuery->paginate(10);
        $pages->appends(array_merge($request->query(), [
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection
        ]));

        return view('admin.pages.index', compact('pages', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
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
                Rule::unique('pages', 'slug'),
            ],
            'content' => 'required|string',
            'is_published' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            // Ensure generated slug is unique
            $count = 0;
            $originalSlug = $validated['slug'];
            while (Page::where('slug', $validated['slug'])->exists()) {
                $count++;
                $validated['slug'] = $originalSlug . '-' . $count;
            }
        } else {
            // Ensure manually entered slug is correctly formatted
            $validated['slug'] = Str::slug($validated['slug']);
        }
        
        $page = Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully: ' . $page->title);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('pages', 'slug')->ignore($page->id),
            ],
            'content' => 'required|string',
            'is_published' => 'boolean',
        ]);

        // Generate or format slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            // Uniqueness check for generated slug (if different from current page's slug)
            $count = 0;
            $originalSlug = $validated['slug'];
            while (Page::where('slug', $validated['slug'])->where('id', '!=', $page->id)->exists()) {
                $count++;
                $validated['slug'] = $originalSlug . '-' . $count;
            }
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully: ' . $page->title);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully: ' . $page->title);
    }
}
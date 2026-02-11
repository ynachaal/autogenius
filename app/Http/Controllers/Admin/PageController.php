<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
     protected $pageService;

      public function __construct(
      
        PageService $pageService,
     
    ) {
      
        $this->pageService = $pageService;
       
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');
        $published = $request->input('published'); // Get the published filter value

        // Start building the query
        $pagesQuery = Page::query();

        // Apply search filter if a query is present
        if ($query) {
            $pagesQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('slug', 'like', '%' . $query . '%');
            });
        }

        // Apply published filter if set
        if ($published !== null && in_array($published, ['0', '1'])) {
            $pagesQuery->where('is_published', $published);
        }

        // --- Sorting ---
        $sortBy = $request->input('sort_by', 'id'); // default sort
        $sortDirection = $request->input('sort_direction', 'asc');

        // Allowed columns to sort by
        $allowedSorts = ['id', 'title', 'slug', 'is_published', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        // Apply sorting
        $pagesQuery->orderBy($sortBy, $sortDirection);

        // --- Pagination ---
        $pages = $pagesQuery->paginate(10);
        $pages->appends(array_merge($request->query(), [
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'published' => $published
        ]));

        return view('admin.pages.index', compact('pages', 'sortBy', 'sortDirection', 'published'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contentAllowedAdmin = true;
        return view('admin.pages.create',compact('contentAllowedAdmin'));
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
                // Ensure slug is unique (ignoring soft-deleted records)
                Rule::unique('pages', 'slug')->whereNull('deleted_at'),
            ],
            'content' => 'required|string',
            'sub_content' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            
            // --- NEW FIELDS VALIDATION ---
            'meta_title' => 'nullable|string|max:100',
            'meta_description' => 'nullable|string|max:500', // Common limit for description
            'meta_keywords' => 'nullable|string|max:500', 
            // -----------------------------
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
      

        return view('admin.pages.edit', compact('page',));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
       
        $validated = $request->validate([
            'title' => 'required|string|max:255', // Uncommented and restored
            'slug' => [
                'nullable',
                'string',
                'max:255',
                // Rule to ensure uniqueness while ignoring the current page's ID
                Rule::unique('pages', 'slug')->ignore($page->id)->whereNull('deleted_at'),
            ],
            'content' => 'nullable|string',
            'sub_content' => 'nullable|string',
            'is_published' => 'nullable|boolean', // Uncommented and restored (using nullable for flexibility)

            // --- NEW FIELDS VALIDATION ---
            'meta_title' => 'nullable|string|max:100',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            // -----------------------------
        ]);

        // Generate or format slug (Uncommented and restored)
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            // Uniqueness check for generated slug
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
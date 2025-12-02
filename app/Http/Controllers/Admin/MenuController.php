<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\Page;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');

        // Start building the query
        $menusQuery = Menu::query();

        // Apply search filter if a query is present
        if ($query) {
            $menusQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                    ->orWhere('external_link', 'like', '%' . $query . '%');
            });
        }

        // --- Sorting ---
        $sortBy = $request->input('sort_by', 'order'); // default sort
        $sortDirection = $request->input('sort_direction', 'asc');

        // Allowed columns to sort by
        $allowedSorts = ['id', 'title', 'external_link', 'order', 'is_active', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'order';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        // Apply sorting
        $menusQuery->orderBy($sortBy, $sortDirection);

        // --- Pagination ---
        $menus = $menusQuery->with(['page', 'post', 'parent', 'category'])->paginate(10);
        $menus->appends(array_merge($request->query(), [
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection
        ]));

        return view('admin.menus.index', compact('menus', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pages = Page::all();
        $posts = Blog::all();
        $menus = Menu::all();
        $categories = MenuCategory::all();
        return view('admin.menus.create', compact('pages', 'posts', 'menus', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'external_link' => 'nullable|url|max:255',
            'page_id' => 'nullable|exists:pages,id',
            'post_id' => 'nullable|exists:blogs,id',
            'parent_id' => 'nullable|exists:menus,id',
            'category_id' => 'nullable|exists:menu_categories,id',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Ensure only one of external_link, page_id, or post_id is provided
        if (
            count(array_filter([
                $validated['external_link'] ?? null,
                $validated['page_id'] ?? null,
                $validated['post_id'] ?? null,
            ])) > 1
        ) {
            return back()->withErrors(['error' => 'Only one of external link, page, or post can be selected.']);
        }

        Menu::create($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully: ' . $validated['title']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        $menu->load(['page', 'post', 'parent', 'category']);
        return view('admin.menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $pages = Page::all();
        $posts = Blog::all();
        $menus = Menu::where('id', '!=', $menu->id)->get();
        $categories = MenuCategory::all();
        return view('admin.menus.edit', compact('menu', 'pages', 'posts', 'menus', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'external_link' => 'nullable|url|max:255',
            'page_id' => 'nullable|exists:pages,id',
            'post_id' => 'nullable|exists:blogs,id',
            'parent_id' => 'nullable|exists:menus,id',
            'category_id' => 'nullable|exists:menu_categories,id',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Ensure only one of external_link, page_id, or post_id is provided
        if (
            count(array_filter([
                $validated['external_link'] ?? null,
                $validated['page_id'] ?? null,
                $validated['post_id'] ?? null,
            ])) > 1
        ) {
            return back()->withErrors(['error' => 'Only one of external link, page, or post can be selected.']);
        }

        // Prevent a menu item from being its own parent
        if ($validated['parent_id'] == $menu->id) {
            return back()->withErrors(['parent_id' => 'A menu item cannot be its own parent.']);
        }

        $menu->update($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully: ' . $menu->title);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully: ' . $menu->title);
    }
}
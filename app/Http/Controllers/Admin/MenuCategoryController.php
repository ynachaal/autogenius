<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');

        // Start building the query
        $categoriesQuery = MenuCategory::query();

        // Apply search filter if a query is present
        if ($query) {
            $categoriesQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('slug', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%');
            });
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');
        $allowedSorts = ['id', 'name', 'slug', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'name';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        // Apply sorting
        $categoriesQuery->orderBy($sortBy, $sortDirection);

        // Pagination
        $categories = $categoriesQuery->paginate(10);
        $categories->appends(array_merge($request->query(), [
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection
        ]));

        return view('admin.menu-categories.index', compact('categories', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.menu-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = MenuCategory::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            // Slug is auto-generated in the model's boot method
        ]);

        return redirect()->route('admin.menu_categories.index')
            ->with('success', 'Menu category created successfully: ' . $category->name);
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuCategory $menuCategory)
    {
        return view('admin.menu-categories.show', compact('menuCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuCategory $menuCategory)
    {
        return view('admin.menu-categories.edit', compact('menuCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuCategory $menuCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $menuCategory->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            // Slug is updated in the model's boot method if name changes
        ]);

        return redirect()->route('admin.menu-categories.index')
            ->with('success', 'Menu category updated successfully: ' . $menuCategory->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuCategory $menuCategory)
    {
        $menuCategory->delete();

        return redirect()->route('admin.menu-categories.index')
            ->with('success', 'Menu category deleted successfully: ' . $menuCategory->name);
    }
}
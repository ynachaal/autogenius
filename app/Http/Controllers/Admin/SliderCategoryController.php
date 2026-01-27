<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SliderCategory;
use Illuminate\Http\Request;

class SliderCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status'); // 1 = active, 0 = inactive

        $query = SliderCategory::query();

        // ---------- SEARCH ----------
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // ---------- STATUS FILTER ----------
        if ($status !== null && in_array($status, ['0', '1'])) {
            $query->where('status', $status);
        }

        // ---------- SORTING ----------
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'desc');
        $allowedSorts = ['id', 'name', 'status', 'created_at'];

        if (!in_array($sortBy, $allowedSorts)) { $sortBy = 'id'; }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'asc';

        $query->orderBy($sortBy, $sortDirection);

        $categories = $query->paginate(10);
        $categories->appends($request->all());

        return view('admin.slider-categories.index', compact('categories', 'sortBy', 'sortDirection', 'search', 'status'));
    }

    public function create()
    {
        return view('admin.slider-categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
          'name' => [
                'required', 
                'string', 
                'max:255', 
                'unique:slider_categories,name,NULL,id,deleted_at,NULL'
            ],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ]);

        SliderCategory::create($validatedData);

        return redirect()->route('admin.slider-categories.index')->with('success', 'Slider Category created successfully!');
    }

    public function show(SliderCategory $sliderCategory)
    {
        return view('admin.slider-categories.show', compact('sliderCategory'));
    }

    public function edit(SliderCategory $sliderCategory)
    {
        return view('admin.slider-categories.edit', compact('sliderCategory'));
    }

    public function update(Request $request, SliderCategory $sliderCategory)
    {
        $validatedData = $request->validate([
           'name' => [
                'required', 
                'string', 
                'max:255', 
                'unique:slider_categories,name,' . $sliderCategory->id . ',id,deleted_at,NULL'
            ],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ]);

        $sliderCategory->update($validatedData);

        return redirect()->route('admin.slider-categories.index')
                         ->with('success', 'Slider Category updated successfully!');
    }

    public function destroy(SliderCategory $sliderCategory)
    {
        $sliderCategory->delete();
        return redirect()->route('admin.slider-categories.index')->with('success', 'Slider Category deleted successfully!');
    }
}
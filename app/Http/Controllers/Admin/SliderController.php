<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\SliderCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $categoryId = $request->input('category'); // Matches your filter dropdown name

        $query = Slider::query()->with('category');

        // ---------- SEARCH ----------
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('heading', 'like', "%{$search}%")
                  ->orWhere('subheading', 'like', "%{$search}%");
            });
        }

        // ---------- STATUS FILTER ----------
        if ($status !== null && in_array($status, ['0', '1'])) {
            $query->where('status', $status);
        }

        // ---------- CATEGORY FILTER ----------
        if ($categoryId) {
            $query->where('slider_category_id', $categoryId);
        }

        // ---------- SORTING ----------
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'desc');
        
        $validSorts = ['id', 'slider_category_id', 'type', 'heading', 'status', 'created_at'];
        $actualSort = in_array($sortBy, $validSorts) ? $sortBy : 'id';
        $actualDir = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        $sliders = $query->orderBy($actualSort, $actualDir)
                         ->paginate(10)
                         ->appends($request->all());

        // For the filter dropdown
        $categories_list = SliderCategory::where('status', 1)->orderBy('name')->get();

        return view('admin.sliders.index', compact(
            'sliders', 
            'categories_list', 
            'search', 
            'status', 
            'categoryId',
            'sortBy',
            'sortDirection'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        // Load the category relationship to show category name in details
        $slider->load('category');
        return view('admin.sliders.show', compact('slider'));
    }

    public function create()
    {
        $categories = SliderCategory::all();
        return view('admin.sliders.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slider_category_id' => 'required|exists:slider_categories,id',
            'type'               => 'required|in:image,video',
            'file'               => 'required|file|mimes:jpg,jpeg,png,mp4|max:20480',
            'heading'            => 'nullable|string|max:255',
            'subheading'         => 'nullable|string|max:255',
            'button1_text'       => 'nullable|string|max:50',
            'button1_link'       => 'nullable|url',
            'status'             => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('sliders', 'public');
        }

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully!');
    }

    public function edit(Slider $slider)
    {
        $categories = SliderCategory::all();
        return view('admin.sliders.edit', compact('slider', 'categories'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'slider_category_id' => 'required|exists:slider_categories,id',
            'type'               => 'required|in:image,video',
            'file'               => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480',
            'heading'            => 'nullable|string|max:255',
            'status'             => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            if ($slider->file && Storage::disk('public')->exists($slider->file)) {
                Storage::disk('public')->delete($slider->file);
            }
            $validated['file'] = $request->file('file')->store('sliders', 'public');
        }

        $slider->update($validated);

        // Redirecting to show page after update, as seen in your BlogCategory example
        return redirect()->route('admin.sliders.show', $slider)->with('success', 'Slider updated successfully!');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->file && Storage::disk('public')->exists($slider->file)) {
            Storage::disk('public')->delete($slider->file);
        }
        
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully!');
    }
}
<?php

namespace App\Services;

use App\Models\Slider;
use App\Models\SliderCategory;
use Illuminate\Database\Eloquent\Collection;

class SliderService
{
    /**
     * Get all active sliders (optionally by category)
     */
    public function getActiveSliders(?int $categoryId = null): Collection
    {
        return Slider::with('category')
            ->active()
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('slider_category_id', $categoryId);
            })
            ->orderBy('order', 'asc')   // ✅ changed
            ->get();
    }

    /**
     * Get active sliders by category name
     */
    public function getByCategoryName(string $categoryName): Collection
    {
        return Slider::with('category')
            ->active()
            ->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', $categoryName)
                  ->where('status', true);
            })
            ->orderBy('order', 'asc')   // ✅ changed
            ->get();
    }

    /**
     * Get active sliders by category ID
     */
    public function getByCategoryId(int $categoryId): Collection
    {
        return Slider::with('category')
            ->active()
            ->where('slider_category_id', $categoryId)
            ->orderBy('order', 'asc')   // ✅ changed
            ->get();
    }

    /**
     * Get all active slider categories with sliders
     */
    public function getActiveCategoriesWithSliders(): Collection
    {
        return SliderCategory::active()
            ->with(['sliders' => function ($q) {
                $q->active()->orderBy('order', 'asc');   // ✅ changed
            }])
            ->get();
    }
}

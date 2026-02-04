<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandService
{
    /**
     * Get all active brands from cache
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllBrands()
    {
        return Cache::remember('brands_all_active', 3600, function () {
            return Brand::where('status', 'active')
                ->orderBy('order')
                ->get();
        });
    }

    /**
     * Get featured brands with count from cache
     *
     * @return array
     */
    public function getFeaturedBrands()
    {
        return Cache::remember('brands_featured', 3600, function () {
            $brands = Brand::where('status', 'active')
                ->where('is_featured', true)
                ->orderBy('order')
                ->get();

            return [
                'brands' => $brands,
                'count' => $brands->count(),
            ];
        });
    }
}
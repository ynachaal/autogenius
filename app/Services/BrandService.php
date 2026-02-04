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
        return Brand::where('status', 'active')
            ->orderBy('order')
            ->get();
    }

    public function getFeaturedBrands()
    {
        $brands = Brand::where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('order')
            ->get();

        return [
            'brands' => $brands,
            'count' => $brands->count(),
        ];
    }

}
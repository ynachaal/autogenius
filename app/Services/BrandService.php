<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BrandService
{
    /**
     * Get all active brands
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllBrands()
    {
        return Brand::where('status', 'active')
            ->orderBy('order')
            ->get();
    }

   

    /**
     * Get featured brands with count
     *
     * @return array
     */
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

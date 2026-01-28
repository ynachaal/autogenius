<?php

namespace App\Services;

use App\Models\Service;
use App\Models\Page;
use App\Models\Brand;

class SearchService
{
    /**
     * Perform a search across Services, Pages, and Brands.
     */
    public function globalSearch(string $term): array
    {
        return [
            'services' => $this->searchServices($term),
            'pages'    => $this->searchPages($term),
        ];
    }

    private function searchServices(string $term)
    {
        return Service::where('status', 1) // 1 = active
            ->where(function ($query) use ($term) {
                $query->where('title', 'LIKE', "%{$term}%")
                      ->orWhere('sub_heading', 'LIKE', "%{$term}%")
                      ->orWhere('description', 'LIKE', "%{$term}%")
                      ->orWhere('meta_keywords', 'LIKE', "%{$term}%");
            })
            ->get(['id', 'title', 'slug', 'image']); // Optimized selection
    }

    private function searchPages(string $term)
    {
        return Page::where('is_published', 1)
            ->where(function ($query) use ($term) {
                $query->where('title', 'LIKE', "%{$term}%")
                      ->orWhere('content', 'LIKE', "%{$term}%")
                      ->orWhere('meta_title', 'LIKE', "%{$term}%");
            })
            ->get(['id', 'title', 'slug']);
    }

    private function searchBrands(string $term)
    {
        return Brand::where('status', 'active')
            ->where(function ($query) use ($term) {
                $query->where('name', 'LIKE', "%{$term}%")
                      ->orWhere('description', 'LIKE', "%{$term}%")
                      ->orWhere('meta_keywords', 'LIKE', "%{$term}%");
            })
            ->orderBy('order', 'asc')
            ->get(['id', 'name', 'slug', 'image']);
    }
}
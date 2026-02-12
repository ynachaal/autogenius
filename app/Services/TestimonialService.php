<?php

namespace App\Services;

use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;

class TestimonialService
{
    /**
     * Get active testimonials with pagination.
     * Note: We usually don't cache full paginators because the cache key 
     * needs to change per page.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedActive($perPage = 12)
    {
        // Get current page to create a unique cache key
        $page = request()->get('page', 1);

        return Cache::remember("testimonials_active_page_{$page}", 3600, function () use ($perPage) {
            return Testimonial::where('status', 1)
                ->orderBy('order', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
    }

    

    public function getActiveCount()
    {
        return Cache::remember('testimonials_active_count', 3600, function () {
            return Testimonial::where('status', 1)->count();
        });
    }
}
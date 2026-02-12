<?php

namespace App\Services;

use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;

class TestimonialService
{
    /**
     * Get the count of active testimonials from cache
     *
     * @return int
     */
    public function getActiveCount()
    {
        return Cache::remember('testimonials_active_count', 3600, function () {
            return Testimonial::where('status', 1)->count();
        });
    }

    /**
     * Get all active testimonials ordered by preference from cache
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActive()
    {
        return Cache::remember('testimonials_all_active', 3600, function () {
            return Testimonial::where('status', 1)
                ->orderBy('order', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
        });
    }

   
}
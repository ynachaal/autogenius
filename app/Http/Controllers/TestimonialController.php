<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Services\TestimonialService;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    /**
     * Display the testimonials page.
     */
    public function index(TestimonialService $testimonialService): View
    {
        // 1. Fetch the page SEO/Content data
        $page = Page::where('slug', 'testimonials')->first();

        // 2. Updated: Call the paginated service (default 12 per page)
        $testimonials = $testimonialService->getPaginatedActive(12);
        
        // 3. Optional: Get the total count
        $testimonialCount = $testimonialService->getActiveCount();

        return view('front.testimonials.index', compact('page', 'testimonials', 'testimonialCount'));
    }
}
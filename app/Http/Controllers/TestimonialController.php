<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Services\TestimonialService; // Import your service
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

        // 2. Call the service to get cached testimonials
        $testimonials = $testimonialService->getAllActive();
        
        // 3. Optional: Get the count if needed for the UI
        $testimonialCount = $testimonialService->getActiveCount();

        return view('front.testimonials.index', compact('page', 'testimonials', 'testimonialCount'));
    }
}
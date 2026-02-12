<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Page;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class TestimonialController extends Controller
{
    public function index(): View
    {
        $page = Page::where('slug', 'testimonials')->first();
        return view('front.testimonials.index', compact('page'));
    }
}
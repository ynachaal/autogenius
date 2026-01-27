<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Services\PageService;
use App\Models\Page;

class FrontPageController extends Controller
{
     protected $pageService;
       public function __construct(
        PageService $pageService,
    ) {
        $this->pageService = $pageService;
    }
    public function showPublic(string $slug)
    {
        
        $page = Page::where('slug', $slug)
            ->where('is_published', 1)
            ->first();

        if (!$page) {

            // Fallback object with meta values as well
            $page = (object) [
                'title' => 'Page Not Found',
                'content' => 'The page you are looking for does not exist.',
                'meta_title' => 'Page Not Found',
                'meta_description' => 'Requested page does not exist.',
                'meta_keywords' => '',
            ];

            return response()->view('site.page', compact('page'), 404);
        }

        return view('site.page', compact('page',));
    }

}
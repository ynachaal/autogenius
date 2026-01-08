<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Support\Collection;

class PageService
{
    /**
     * Fetch published pages for dropdown.
     *
     * @return Collection
     */
    public function fetchPageDD(): Collection
    {
        return Page::where('is_published', true)
            ->orderBy('title', 'asc')
            ->get(['title', 'slug']);
    }

    /**
     * Get a published page by slug.
     *
     * @param string $slug
     * @return Page|null
     */
    public function getPageBySlug(string $slug): ?Page
    {
        return Page::where('slug', $slug)
            ->first();
    }

    public function getPageById(string $id): ?Page
    {
        return Page::where('is_published', true)
            ->where('id', $id)
            ->first();
    }

    public function checkIfServicePage(string $slug): ?Page
    {
        $serviceArray = [
            'banking',
            'interior',
            'development',
            'valuation',
            'snagging',
            'aml',
            'mortgage',
            'will-services',
            'property-management',
        ];

        if (in_array($slug, $serviceArray, true)) {
            return Page::where('slug', $slug)->first();
        }

        return null;
    }
    public function contentAllowedAdmin(string $slug): ?Page
    {
        $serviceArray = [
            'banking',
            'interior',
            'development',
            'valuation',
            'snagging',
            'aml',
            'mortgage',
            'will-services',
            'property-management',
            'privacy-policy',
            'terms-conditions',
            'career',
            'about-us',
            'off-plan',
            'developer-partners',
            'foreign-investor',
            'safest-long-tem-investors',
        ];

        if (in_array($slug, $serviceArray, true)) {
            return Page::where('slug', $slug)->first();
        }

        return null;
    }
}

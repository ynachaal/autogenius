<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PageService
{
    /**
     * Get all active pages.
     */
    public function getAllActivePages(): Collection
    {
        return Cache::remember('pages_all_active', 3600, function () {
            return Page::active()
                ->orderBy('id', 'asc')
                ->get();
        });
    }

    /**
     * Get paginated pages.
     * Note: We include the page number in the cache key.
     */
    public function getPaginatedPages(int $perPage = 12): LengthAwarePaginator
    {
        $page = request()->get('page', 1);
        $key = "pages_paginated_{$perPage}_page_{$page}";

        return Cache::remember($key, 3600, function () use ($perPage) {
            return Page::active()
                ->orderBy('id', 'asc')
                ->paginate($perPage);
        });
    }

    /**
     * Get featured pages.
     */
    public function getFeaturedPages(int $limit = 5): Collection
    {
        return Cache::remember("pages_featured_{$limit}", 3600, function () use ($limit) {
            return Page::active()
                ->where('is_featured', true)
                ->orderBy('id', 'asc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get a page by slug.
     */
    public function getBySlug(string $slug): ?Page
    {
        return Cache::remember("page_slug_{$slug}", 3600, function () use ($slug) {
            return Page::active()
                ->where('slug', $slug)
                ->first();
        });
    }

    /**
     * Find a page by slug or fail.
     */
    public function findBySlug(string $slug): Page
    {
        $page = $this->getBySlug($slug);

        if (!$page) {
            abort(404);
        }

        return $page;
    }
}
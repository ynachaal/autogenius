<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PageService
{
    /**
     * Get all active pages.
     */
    public function getAllActivePages(): Collection
    {
        return Page::active()
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Get paginated pages.
     */
    public function getPaginatedPages(int $perPage = 12): LengthAwarePaginator
    {
        return Page::active()
            ->orderBy('id', 'asc')
            ->paginate($perPage);
    }

    /**
     * Get featured pages (optional if you have a 'featured' column).
     */
    public function getFeaturedPages(int $limit = 5): Collection
    {
        return Page::active()
            ->where('is_featured', true)
            ->orderBy('id', 'asc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get a page by slug.
     */
    public function getBySlug(string $slug): ?Page
    {
        return Page::active()
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Find a page by slug or fail.
     */
    public function findBySlug(string $slug): Page
    {
        return Page::active()
            ->where('slug', $slug)
            ->firstOrFail();
    }
}

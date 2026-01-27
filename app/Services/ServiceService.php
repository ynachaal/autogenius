<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ServiceService
{
    /**
     * Get all active services.
     */
    public function getActiveServices(): Collection
    {
        return Service::active()
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Get up to 8 featured services for the homepage.
     */
    public function getFeaturedServices(int $limit = 8): Collection
    {
        return Service::active()
            ->featured()
            ->orderBy('id', 'asc')
            ->limit($limit)
            ->get();
    }

     public function getPaginatedServices(int $perPage = 12): LengthAwarePaginator
    {
        return Service::active()
            ->orderBy('id', 'asc')
            ->paginate($perPage);
    }

    public function getAllActiveServices(): Collection
    {
        return Service::active()
            ->orderBy('id', 'asc')
            ->get();
    }

    public function getBySlug(string $slug): ?Service
    {
        return Service::active()
            ->where('slug', $slug)
            ->first();
    }

    

    /**
     * Find a specific service by its slug.
     */
    public function findBySlug(string $slug): ?Service
    {
        return Service::active()
            ->where('slug', $slug)
            ->firstOrFail();
    }
}
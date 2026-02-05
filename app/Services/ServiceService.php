<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
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
        return Cache::remember("services_featured_{$limit}", 3600, function () use ($limit) {
            return Service::active()
                ->featured()
                ->orderBy('id', 'asc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get paginated services.
     */
    public function getPaginatedServices(int $perPage = 12): LengthAwarePaginator
    {
        return Service::active()
            ->orderBy('id', 'asc')
            ->paginate($perPage);
    }

    /**
     * Duplicate of getActiveServices - kept for compatibility.
     */
    public function getAllActiveServices(): Collection
    {
        return $this->getActiveServices();
    }

    /**
     * Get a service by slug.
     */
    public function getBySlug(string $slug): ?Service
    {
        return Service::active()
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Find a specific service by its slug or fail.
     */
    public function findBySlug(string $slug): Service
    {
        $service = $this->getBySlug($slug);

        if (!$service) {
            abort(404);
        }

        return $service;
    }
    public function getActiveServicesCount(): int
    {
        return Cache::remember('services_active_count', 3600, function () {
            return Service::active()->count();
        });
    }
}

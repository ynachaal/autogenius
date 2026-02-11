<?php

namespace App\Services;

use App\Models\ServiceFee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ServiceFeeService
{
    /**
     * Get all active service fees for the front-end display.
     * Cached for 24 hours to improve performance.
     */
    public function getActiveFees(): Collection
    {
        return Cache::remember('active_service_fees', now()->addDay(), function () {
            return ServiceFee::where('status', true)
                ->orderBy('full_report_fee', 'asc')
                ->get();
        });
    }

    /**
     * Find a specific fee by segment name (useful for booking flows).
     */
    public function getFeeBySegment(string $segment): ?ServiceFee
    {
        return ServiceFee::where('car_segment', $segment)
            ->where('status', true)
            ->first();
    }

    /**
     * Find a specific fee by ID.
     */
    public function getFeeById(int $id): ?ServiceFee
    {
        return ServiceFee::where('id', $id)
            ->where('status', true)
            ->first();
    }

    /**
     * Format the price with the Rupee symbol for the UI.
     */
    public function formatPrice($amount): string
    {
        return '₹' . number_format($amount, 2);
    }
}
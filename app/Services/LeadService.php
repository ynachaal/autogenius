<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Cache;

class LeadService
{
    /**
     * Get total leads count from cache.
     */
    public function getTotalLeadsCount(): int
    {
        return Cache::remember('leads_total_count', 3600, function () {
            return Lead::count();
        });
    }

    /**
     * Get recent leads.
     */
    public function getRecentLeads(int $limit = 10)
    {
        return Lead::latest()->limit($limit)->get();
    }
}
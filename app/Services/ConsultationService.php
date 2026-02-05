<?php

namespace App\Services;

use App\Models\Consultation;
use Illuminate\Support\Facades\Cache;

class ConsultationService
{
    /**
     * Get various consultation stats from cache.
     */
    public function getConsultationStats(): array
    {
        return Cache::remember('consultation_stats', 3600, function () {
            return [
                'total' => Consultation::count(),
                'pending' => Consultation::where('status', 'pending')->count(),
                'completed' => Consultation::where('status', 'completed')->count(),
            ];
        });
    }
}
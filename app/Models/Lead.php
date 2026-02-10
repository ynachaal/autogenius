<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class Lead extends Model
{
    protected $fillable = [
        'full_name',
        'mobile',
        'city',
        'service_required',
        'preferred_contact_method',
        'budget',
        'max_budget',
        'ownership_period',
        'primary_usage',
        'running_pattern',
        'approx_running',
        'passengers',
        'body_type',
        'fuel_preference',
        'gearbox',
        'ride_comfort',
        'feature_priority',
        'noise_sensitivity',
        'color_preference',
        'max_owners',
        'accident_history',
        'insurance_preference',
        'purchase_timeline',
        'decision_maker',
        'existing_car',
        'upgrade_reason',
        'declaration',
        'email',
        'service_type', // New field for service type
    ];

    protected $casts = [
        'body_type' => 'array',
        'fuel_preference' => 'array',
        'feature_priority' => 'array',
        'declaration' => 'boolean',
    ];

    /**
     * Payments linked to this lead
     */
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable', 'entity_type', 'entity_id');
    }

    /**
     * Check if lead payment is completed
     */
    public function isPaid(): bool
    {
        return $this->payments()
            ->where('status', 'paid')
            ->exists();
    }
}

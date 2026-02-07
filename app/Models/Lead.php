<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

        // Razorpay
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'payment_status',
        'amount_paid',
        'currency',
        'payment_method',
        'payment_for',
        'paid_at',
        'razorpay_payload',
    ];

    protected $casts = [
        'body_type' => 'array',
        'fuel_preference' => 'array',
        'feature_priority' => 'array',
        'declaration' => 'boolean',
    ];
}

?>
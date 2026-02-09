<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_type',
        'entity_id',
        'gateway',
        'order_id',
        'payment_id',
        'signature',
        'amount',
        'currency',
        'status',
        'payment_method',
        'paid_at',
        'gateway_payload',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'gateway_payload' => 'array',
    ];

    /**
     * Polymorphic relation to payable entities
     */
    public function payable()
    {
        return $this->morphTo(null, 'entity_type', 'entity_id');
    }
}

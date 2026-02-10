<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceFee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'car_segment',
        'full_report_fee',
        'booking_amount',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}

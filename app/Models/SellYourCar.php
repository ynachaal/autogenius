<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellYourCar extends Model
{
    use HasFactory;

    // Explicitly tell Laravel the table name since it's not standard plural
    protected $table = 'sell_your_cars';

    // The fields that can be filled during form submission
    protected $fillable = [
        'vehicle_name',
        'year',
        'kms_driven',
        'no_of_owners',
        'customer_email',
        'registration_number',
        'car_location',
        'customer_name',
        'customer_mobile',
        'car_photos',
    ];

    /**
     * If you plan to store car_photos as an array (multiple photos), 
     * uncomment the line below to automatically convert JSON to Array.
     */
    // protected $casts = ['car_photos' => 'array'];
}
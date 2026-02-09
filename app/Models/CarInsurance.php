<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CarInsurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_mobile',
        'vehicle_reg_no',
        'rc_path',
        'insurance_path',
        'status',
    ];

    /**
     * Get all of the insurance's payments.
     */
    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'entity');
    }
}
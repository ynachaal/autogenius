<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ServiceInsuranceClaim extends Model
{
    use HasFactory;

    // 1. Explicitly define the table name
    protected $table = 'service_insurance_claims';

    // 2. Add the missing fields you added in the migration
    protected $fillable = [
        'customer_name',
        'customer_mobile',
        'service_type',     // Added
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
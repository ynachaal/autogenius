<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class CarInspection extends Model
{
    use HasFactory;

    protected $table = 'car_inspections';

    protected $fillable = [
        'customer_name',
        'customer_mobile',
        'customer_email',
        'vehicle_name',
        'service_type',
        'inspection_date',
        'inspection_location',
        'status',
    ];

    protected $casts = [
        'inspection_date' => 'date:d-m-Y', // Displays as 10-02-2026 automatically
   
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Polymorphic relation using custom entity columns
     */
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable', 'entity_type', 'entity_id');
    }

    /**
     * Check if inspection is paid
     */
    public function isPaid(): bool
    {
        // Calling the relationship method ensures it uses entity_type/entity_id
        return $this->payments()->where('status', 'paid')->exists();
    }

    /**
     * Latest successful payment
     */
    public function latestPayment()
    {
        return $this->payments()
            ->where('status', 'paid')
            ->latest() // Uses created_at by default
            ->first();
    }
}
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
        'inspection_date',
        'inspection_location',
        'status',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Payments related to this inspection
     */
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable', 'entity_type', 'entity_id');
    }

    /**
     * Latest successful payment
     */
    public function latestPayment()
    {
        return $this->payments()
            ->where('status', 'paid')
            ->latest('paid_at');
    }

    /**
     * Check if inspection is paid
     */
    public function isPaid(): bool
    {
        return $this->payments()
            ->where('status', 'paid')
            ->exists();
    }
}

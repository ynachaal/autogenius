<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class CallConsultation extends Model
{
    use HasFactory;

    protected $table = 'callconsultations';

    protected $fillable = [
        'customer_name',
        'customer_mobile',
        'customer_email',
        'selected_service', // The specific option from the dropdown
        'service_type',     // Replaced page_slug
        'status',
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
     * Check if consultation is paid
     */
    public function isPaid(): bool
    {
        return $this->payments()->where('status', 'paid')->exists();
    }

    /**
     * Latest successful payment
     */
    public function latestPayment()
    {
        return $this->payments()
            ->where('status', 'paid')
            ->latest()
            ->first();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'preferred_date',
        'status',
        'amount',
    ];

    /**
     * Payments related to this consultation
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
        return $this->payments()
            ->where('status', 'paid')
            ->exists();
    }
}

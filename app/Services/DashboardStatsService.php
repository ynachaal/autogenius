<?php

namespace App\Services;

use App\Models\CallConsultation;
use App\Models\CarInspection;
use App\Models\SellYourCar;
use App\Models\ServiceInsuranceClaim;

class DashboardStatsService
{
    /**
     * Get counts for all entities
     */
    public function getStats(): array
    {
        return [
            'consultations' => [
                'total' => CallConsultation::count(),
                'pending' => CallConsultation::where('status', 'pending')->count(),
                'paid' => CallConsultation::whereHas('payments', function($q) {
                    $q->where('status', 'paid');
                })->count(),
            ],
            'inspections' => [
                'total' => CarInspection::count(),
                'pending' => CarInspection::where('status', 'pending')->count(),
                'paid' => CarInspection::whereHas('payments', function($q) {
                    $q->where('status', 'paid');
                })->count(),
            ],
            'insurance_claims' => [
                'total' => ServiceInsuranceClaim::count(),
                'paid' => ServiceInsuranceClaim::whereHas('payments', function($q) {
                    $q->where('status', 'paid');
                })->count(),
            ],
            'car_sales' => [
                'total' => SellYourCar::count(),
            ],
        ];
    }

    /**
     * Generic method to verify a payment for any entity
     */
    public function verifyPayment($model, $paymentId)
    {
        $payment = $model->payments()->findOrFail($paymentId);
        
        return $payment->update([
            'status' => 'paid',
            'verified_at' => now(),
        ]);
    }
}
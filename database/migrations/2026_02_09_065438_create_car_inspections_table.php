<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_inspections', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_mobile');
            $table->string('customer_email');
            $table->string('vehicle_name');
            $table->string('inspection_date', 6); // DDMMYY
            $table->string('inspection_location');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');

            // --- Razorpay & Payment Fields ---
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->unsignedInteger('amount_paid')->nullable(); // Amount in paise
            $table->string('currency', 10)->default('INR');
            $table->string('payment_method')->nullable(); // upi, card, etc.
            
            $table->timestamp('paid_at')->nullable();
            $table->json('razorpay_payload')->nullable(); // Raw response for debugging

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_inspections');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {

            // Razorpay IDs
            $table->string('razorpay_order_id')->nullable()->after('declaration');
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();

            // Payment status
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])
                  ->default('pending');

            // Payment meta
            $table->unsignedInteger('amount_paid')->nullable(); // in paise or rupees (be consistent)
            $table->string('currency', 10)->default('INR');
            $table->string('payment_method')->nullable(); // upi, card, netbanking

            // Business tracking
            $table->string('payment_for')->nullable(); // service name / plan
            $table->timestamp('paid_at')->nullable();

            // Optional: store raw webhook payload
            $table->json('razorpay_payload')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'razorpay_order_id',
                'razorpay_payment_id',
                'razorpay_signature',
                'payment_status',
                'amount_paid',
                'currency',
                'payment_method',
                'payment_for',
                'paid_at',
                'razorpay_payload',
            ]);
        });
    }
};


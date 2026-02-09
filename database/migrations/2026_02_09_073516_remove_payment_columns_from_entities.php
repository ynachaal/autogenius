<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('car_inspections', function (Blueprint $table) {
            $table->dropColumn([
                'razorpay_order_id',
                'razorpay_payment_id',
                'razorpay_signature',
                'payment_status',
                'amount_paid',
                'currency',
                'payment_method',
                'paid_at',
                'razorpay_payload',
            ]);
        });

        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn([
                'razorpay_order_id',
                'razorpay_payment_id',
                'razorpay_signature',
                'payment_status',
            ]);
        });

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

    public function down(): void
    {
        Schema::table('car_inspections', function (Blueprint $table) {
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->enum('payment_status', ['pending','paid','failed','refunded'])->default('pending');
            $table->unsignedInteger('amount_paid')->nullable();
            $table->string('currency', 10)->default('INR');
            $table->string('payment_method')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('razorpay_payload')->nullable();
        });

        Schema::table('consultations', function (Blueprint $table) {
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->string('payment_status')->default('pending');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->enum('payment_status', ['pending','paid','failed','refunded'])->default('pending');
            $table->unsignedInteger('amount_paid')->nullable();
            $table->string('currency', 10)->default('INR');
            $table->string('payment_method')->nullable();
            $table->string('payment_for')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('razorpay_payload')->nullable();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Polymorphic link to any payable entity
            $table->string('entity_type', 50); // car_inspection | consultation | lead
            $table->unsignedBigInteger('entity_id');

            $table->enum('gateway', ['razorpay'])->default('razorpay');

            $table->string('order_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('signature')->nullable();

            $table->unsignedInteger('amount');
            $table->string('currency', 10)->default('INR');

            $table->enum('status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();

            $table->timestamp('paid_at')->nullable();
            $table->json('gateway_payload')->nullable();

            $table->timestamps();

            $table->index(['entity_type', 'entity_id']);
            $table->unique(['gateway', 'payment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

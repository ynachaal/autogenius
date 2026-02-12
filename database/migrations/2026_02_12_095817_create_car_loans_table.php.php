<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_type'); // New Car Loan or Used Car Loan
            $table->string('customer_name');
            $table->string('customer_mobile');
            $table->string('customer_email')->nullable(); // Added Email Field
            $table->string('city');
            $table->string('status')->default('pending'); // Useful for tracking leads
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_loans');
    }
};
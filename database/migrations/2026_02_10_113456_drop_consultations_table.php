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
        Schema::dropIfExists('consultations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This allows you to roll back if you change your mind
        Schema::create('consultations', function (Blueprint $blade) {
            $blade->id();
            $blade->string('name')->nullable();
            $blade->string('email')->nullable();
            $blade->string('phone')->nullable();
            $blade->string('subject')->nullable();
            $blade->date('preferred_date')->nullable();
            $blade->text('message')->nullable();
            $blade->string('status')->default('pending');
            $blade->decimal('amount', 10, 2)->default(0);
            $blade->string('payment_status')->default('pending');
            $blade->timestamps();
        });
    }
};
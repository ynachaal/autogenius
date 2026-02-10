<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('callconsultations', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name');
        $table->string('customer_mobile');
        $table->string('customer_email');
        $table->string('selected_service'); // The option from the dropdown
        $table->string('service_type')->nullable(); // Replaced page_slug
        $table->string('status')->default('pending'); // Default status
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('callconsultations');
    }
};

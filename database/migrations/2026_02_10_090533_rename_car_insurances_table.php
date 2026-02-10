<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Rename the table
        Schema::rename('car_insurances', 'service_insurance_claims');

        // 2. Add the service_type column
        Schema::table('service_insurance_claims', function (Blueprint $table) {
            $table->string('service_type')->after('customer_mobile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Remove the column first
        Schema::table('service_insurance_claims', function (Blueprint $table) {
            $table->dropColumn('service_type');
        });

        // 2. Rename it back
        Schema::rename('service_insurance_claims', 'car_insurances');
    }
};
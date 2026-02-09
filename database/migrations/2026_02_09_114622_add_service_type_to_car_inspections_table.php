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
        Schema::table('car_inspections', function (Blueprint $table) {
            // Adding service_type to identify if it's Hatchback, SUV, Luxury, etc.
            $table->string('service_type')->nullable()->after('vehicle_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_inspections', function (Blueprint $table) {
            $table->dropColumn('service_type');
        });
    }
};
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
        Schema::table('car_insurances', function (Blueprint $table) {
            // Remove the column
            $table->dropColumn('vehicle_reg_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_insurances', function (Blueprint $table) {
            // Add it back in case of rollback
            $table->string('vehicle_reg_no')->after('customer_mobile');
        });
    }
};
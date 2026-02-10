<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add to service_insurance_claims
        Schema::table('service_insurance_claims', function (Blueprint $table) {
            $table->string('customer_email')->after('customer_mobile')->nullable();
        });

        // 2. Add to sell_your_cars
        Schema::table('sell_your_cars', function (Blueprint $table) {
            $table->string('customer_email')->after('customer_mobile')->nullable();
        });

        // 3. Add to leads (The "Smart Car Requirements" table)
        Schema::table('leads', function (Blueprint $table) {
            $table->string('email')->after('mobile')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('service_insurance_claims', function (Blueprint $table) {
            $table->dropColumn('customer_email');
        });

        Schema::table('sell_your_cars', function (Blueprint $table) {
            $table->dropColumn('customer_email');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};
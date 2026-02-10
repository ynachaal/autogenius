<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Convert DDMMYY strings to YYYY-MM-DD format so MySQL can read them
        // This takes '100226' and turns it into '2026-02-10'
        DB::statement("UPDATE car_inspections SET inspection_date = STR_TO_DATE(inspection_date, '%d%m%y') WHERE inspection_date IS NOT NULL");

        // 2. Change the column type to DATE
        Schema::table('car_inspections', function (Blueprint $table) {
            $table->date('inspection_date')->change();
        });
    }

    public function down(): void
    {
        Schema::table('car_inspections', function (Blueprint $table) {
            $table->string('inspection_date', 6)->change();
        });
    }
};
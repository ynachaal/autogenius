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
         Schema::table('faqs', function (Blueprint $table) {
            // Add 'order' as an unsigned small integer, defaulting to 0 for sorting.
            $table->unsignedSmallInteger('order')->default(0)->after('answer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};

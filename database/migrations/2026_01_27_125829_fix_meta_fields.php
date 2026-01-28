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
        // Modify services table
        Schema::table('services', function (Blueprint $table) {
            $table->string('meta_title', 100)->nullable()->change();
            $table->string('meta_description', 500)->nullable()->change();
            $table->string('meta_keywords', 500)->nullable()->change();
        });

        // Modify pages table
        Schema::table('pages', function (Blueprint $table) {
            $table->string('meta_title', 100)->nullable()->change();
            $table->string('meta_description', 500)->nullable()->change();
            $table->string('meta_keywords', 500)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->change();
            $table->string('meta_description')->nullable()->change();
            $table->string('meta_keywords')->nullable()->change();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->change();
            $table->string('meta_description')->nullable()->change();
            $table->string('meta_keywords')->nullable()->change();
        });
    }
};

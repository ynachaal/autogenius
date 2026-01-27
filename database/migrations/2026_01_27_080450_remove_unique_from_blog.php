<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Drop the unique index on slug
            $table->dropUnique('blogs_slug_unique'); // default index name
            // If index name differs, use $table->dropUnique(['slug']);
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->unique('slug');
        });
    }
};

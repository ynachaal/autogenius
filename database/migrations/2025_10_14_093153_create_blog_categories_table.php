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
        // 1. Create the categories table
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Modify the existing 'blogs' table to add the required foreign key
        // Note: This assumes the 'blogs' table already exists from a previous migration.
        Schema::table('blogs', function (Blueprint $table) {
            if (!Schema::hasColumn('blogs', 'category_id')) {
                // This implements the single, required category (One-to-Many relationship)
                $table->foreignId('category_id')
                    ->constrained('blog_categories') 
                    ->onDelete('restrict') // Category must be emptied before deletion
                    ->after('author_id');
            }
        });
        
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key and column from the 'blogs' table
        Schema::table('blogs', function (Blueprint $table) {
            if (Schema::hasColumn('blogs', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
        });

        // Drop the main categories table
        Schema::dropIfExists('blog_categories');
    }
};

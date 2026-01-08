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
        // Tables that should have Soft Deletes
        $tables = [
            'users', 
            'blog_categories', 
            'blogs', 
            'pages', 
            'faqs', 
            'property_areas', 
            'properties', 
            'developer_partners',
            'why_choose_us',
            'property_types',
        ];

        foreach ($tables as $table) {
            // Check if the table exists before attempting to modify it
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }
        }

        // Optional: Adding soft deletes to menus/menu_categories if they are editable/removable
        // if (Schema::hasTable('menu_categories') && !Schema::hasColumn('menu_categories', 'deleted_at')) {
        //     Schema::table('menu_categories', function (Blueprint $table) {
        //         $table->softDeletes();
        //     });
        // }
        // if (Schema::hasTable('menus') && !Schema::hasColumn('menus', 'deleted_at')) {
        //     Schema::table('menus', function (Blueprint $table) {
        //         $table->softDeletes();
        //     });
        // }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users', 
            'blog_categories', 
            'blogs', 
            'pages', 
            'faqs', 
            // 'menu_categories', // Optional: if added above
            // 'menus',           // Optional: if added above
        ];

        foreach ($tables as $table) {
            // Check if the table and the column exist before attempting to drop it
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $table) {
                    // This method removes the 'deleted_at' column and any corresponding index
                    $table->dropSoftDeletes();
                });
            }
        }
    }
};
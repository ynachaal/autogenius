<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('email_templates')
            ->where('title', 'Welcome Email')
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional: re-insert if you ever rollback
        DB::table('email_templates')->insert([
            'title' => 'Welcome Email',
            'subject' => 'Welcome to Autogenious!',
            'content' => '...same HTML as before...',
            'is_published' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};

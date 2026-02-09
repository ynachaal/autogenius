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
            ->where('title', 'New Lead Alert - Admin')
            ->update([
                // Removed {{full_name}} as requested
                'subject' => 'New Lead Inquiry - {{service_required}}'
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('email_templates')
            ->where('title', 'New Lead Alert - Admin')
            ->update([
                'subject' => 'New Lead: {{full_name}} - {{service_required}}'
            ]);
    }
};
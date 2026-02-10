<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Titles provided by the user
        $titlesToRemove = [
            'Book a Consultation - Confirmation',
            'Book a Consultation - Admin',
            'Lead Inquiry Confirmation - User'
        ];

        DB::table('email_templates')
            ->whereIn('title', $titlesToRemove)
            ->delete();
    }

    /**
     * Reverse the migrations.
     * * Note: Reversing a delete migration is difficult unless you 
     * hardcode the content back in. Usually, for data cleanup,
     * the down method is left empty or logs a warning.
     */
    public function down(): void
    {
        // Since the data is deleted, we cannot easily restore it automatically.
    }
};
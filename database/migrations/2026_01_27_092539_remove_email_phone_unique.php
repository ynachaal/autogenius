<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop unique constraint on email
            $table->dropUnique('users_email_unique'); 
            
            // Drop unique constraint on phone_number
            $table->dropUnique('users_phone_number_unique'); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore unique constraints if rollback
            $table->unique('email');
            $table->unique('phone_number');
        });
    }
};

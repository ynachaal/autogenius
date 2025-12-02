<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Changes the 'content' column type to LONGTEXT to support large page content,
     * including embedded Base64 images from the Quill editor.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Change the column type to longText
            $table->longText('content')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * Reverts the column back to the standard text type on rollback.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Warning: Reverting to 'text' may truncate long content
            $table->text('content')->change();
        });
    }
};

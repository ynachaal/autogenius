<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Changes the 'content' column type to LONGTEXT to support large blog posts,
     * especially those containing embedded Base64 images from the Quill editor.
     */
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // The 'change()' method is required after defining the new type (longText)
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
        Schema::table('blogs', function (Blueprint $table) {
            // Warning: Reverting to 'text' may cause data truncation if content is too long.
            $table->text('content')->change(); 
        });
    }
};

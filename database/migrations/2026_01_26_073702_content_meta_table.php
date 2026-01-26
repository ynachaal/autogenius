<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_meta', function (Blueprint $table) {
            $table->id();
            $table->string('meta_key');
            $table->longText('meta_value')->nullable(); // can store text, JSON, HTML blocks
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_meta');
    }
};

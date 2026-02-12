<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('youtube_url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true); // true = active, false = inactive
            $table->timestamps(); // This covers your 'timestamp' requirement
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
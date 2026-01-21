<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            // Foreign key linking to slider_categories
            $table->foreignId('slider_category_id')->constrained('slider_categories')->onDelete('cascade');
            
            // Content fields
            $table->string('type')->default('image'); // video, image
            $table->string('file'); // The path to the media
            $table->string('heading')->nullable();
            $table->string('subheading')->nullable();
            
            // Interaction fields
            $table->string('button1_text')->nullable();
            $table->string('button1_link')->nullable();
            $table->string('button2_text')->nullable();
            $table->string('button2_link')->nullable();
            
            // Status and tracking
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
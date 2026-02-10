<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_fees', function (Blueprint $table) {
            $table->id();
            $table->string('car_segment'); 
            $table->decimal('full_report_fee', 10, 2);
            $table->decimal('booking_amount', 10, 2);
            $table->boolean('status')->default(true); // 1 = active, 0 = inactive
            $table->timestamps();
            $table->softDeletes(); // adds deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_fees');
    }
};

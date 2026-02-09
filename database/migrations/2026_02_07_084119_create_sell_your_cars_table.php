<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sell_your_cars', function (Blueprint $table) {
            $table->id();
            // Vehicle Details
            $table->string('vehicle_name');
            $table->year('year');
            $table->integer('kms_driven');
            $table->integer('no_of_owners');
            $table->string('registration_number');
            $table->string('car_location');

            // Customer Details
            $table->string('customer_name');
            $table->string('customer_mobile');

            // Media (Optional)
            $table->text('car_photos')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sell_your_cars');
    }
};


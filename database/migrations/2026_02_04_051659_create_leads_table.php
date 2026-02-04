<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            // Step 1 – Lead
            $table->string('full_name');
            $table->string('mobile');
            $table->string('city');
            $table->string('service_required');
            $table->string('preferred_contact_method');

            // Step 2 – Budget
            $table->unsignedInteger('budget');
            $table->unsignedInteger('max_budget')->nullable();
            $table->string('ownership_period');

            // Step 3 – Usage
            $table->string('primary_usage');
            $table->string('running_pattern');
            $table->unsignedInteger('approx_running')->nullable();
            $table->string('passengers')->nullable();

            // Step 4 – Preferences
            $table->json('body_type')->nullable();
            $table->json('fuel_preference')->nullable();
            $table->string('gearbox')->nullable();
            $table->string('ride_comfort')->nullable();
            $table->json('feature_priority')->nullable();
            $table->string('noise_sensitivity')->nullable();
            $table->string('color_preference')->nullable();

            // Step 5 – Pre-Owned
            $table->string('max_owners')->nullable();
            $table->string('accident_history')->nullable();
            $table->string('insurance_preference')->nullable();
            $table->string('purchase_timeline')->nullable();

            // Step 6 – Final
            $table->string('decision_maker')->nullable();
            $table->string('existing_car')->nullable();
            $table->text('upgrade_reason')->nullable();
            $table->boolean('declaration')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};


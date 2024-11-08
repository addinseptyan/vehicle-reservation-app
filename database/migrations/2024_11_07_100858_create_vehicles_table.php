<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            // Vehicle basic information
            $table->string('plate_number')->unique()->comment('Vehicle plate number');
            $table->enum('vehicle_type', ['Passenger', 'Cargo'])->default('Passenger')->comment('Type of vehicle use');
            $table->decimal('fuel_consumption', 10, 2)->comment('Fuel consumption per kilometer in liters');
            $table->boolean('availability_status')->default(true)->index()->comment('Whether the vehicle is available for use');
            $table->string('region')->comment('Location of the vehicle, e.g., HQ, Branch Office, Mine 1-6');
            $table->enum('ownership', ['Company-owned', 'Rented'])->comment('Ownership of the vehicle');

            // Tracking and history fields
            $table->date('last_service_date')->nullable()->comment('Last service date');
            $table->date('next_service_date')->nullable()->comment('Next service date');
            $table->date('usage_start_date')->nullable()->comment('Start date of current or most recent usage');
            $table->date('usage_end_date')->nullable()->comment('End date of current or most recent usage');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};

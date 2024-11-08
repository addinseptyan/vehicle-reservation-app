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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('driver_id')->nullable()->constrained('users');
            $table->foreignId('approver_id')->constrained('users');
            $table->foreignId('approver_level2_id')->nullable()->constrained('users');
            $table->enum('approved_by_supervisor', ['pending', 'approved', 'rejected'])->default('pending')->comment('Approval from supervisor');
            $table->enum('approved_by_manager', ['pending', 'approved', 'rejected'])->default('pending')->comment('Approval from manager');
            $table->enum('reservation_status', ['pending', 'approved', 'rejected']);
            $table->dateTime('usage_start');
            $table->dateTime('usage_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::role('admin')->first();
        $approver = User::role('supervisor')->first();
        $approverLevel2 = User::role('manager')->first();

        // Create sample reservations
        Reservation::create([
            'vehicle_id' => Vehicle::inRandomOrder()->first()->id,
            'user_id' => $admin->id,
            'driver_id' => User::role('driver')->inRandomOrder()->first()->id,
            'approver_id' => $approver->id,
            'approver_level2_id' => $approverLevel2->id,
            'reservation_status' => 'pending',
            'usage_start' => now()->addDays(1), // usage start date
            'usage_end' => now()->addDays(3), // usage end date
        ]);

        Reservation::create([
            'vehicle_id' => Vehicle::inRandomOrder()->first()->id,
            'user_id' => $admin->id,
            'driver_id' => User::role('driver')->inRandomOrder()->first()->id,
            'approver_id' => $approver->id,
            'approver_level2_id' => $approverLevel2->id,
            'reservation_status' => 'pending',
            'usage_start' => now()->addDays(4),
            'usage_end' => now()->addDays(7),
        ]);

        Reservation::create([
            'vehicle_id' => Vehicle::inRandomOrder()->first()->id,
            'user_id' => $admin->id,
            'driver_id' => User::role('driver')->inRandomOrder()->first()->id,
            'approver_id' => $approver->id,
            'approver_level2_id' => $approverLevel2->id,
            'reservation_status' => 'pending',
            'usage_start' => now()->addDays(8),
            'usage_end' => now()->addDays(10),
        ]);
    }
}

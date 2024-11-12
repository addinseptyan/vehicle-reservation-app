<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        foreach (range(1, 50) as $index) {
            Booking::create([
                'vehicle_id' => $vehicles->random()->id,
                'driver_id' => $drivers->random()->id,
                'status' => 'pending',
                'start_time' => fake()->dateTimeBetween('now', '+1 week'),
                'end_time' => fake()->dateTimeBetween('+1 week', '+2 weeks'),
            ]);
        }
    }
}

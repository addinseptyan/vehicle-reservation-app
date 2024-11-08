<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::create([
            'plate_number' => 'AB123CD',
            'vehicle_type' => 'Passenger',
            'fuel_consumption' => 8.5,
            'availability_status' => true,
            'region' => 'HQ',
            'ownership' => 'Company-owned',
            'last_service_date' => now()->subMonths(3),
            'next_service_date' => now()->addMonths(3),
            'usage_start_date' => now()->subDays(2),
            'usage_end_date' => now()->addDays(5),
        ]);

        Vehicle::create([
            'plate_number' => 'EF456GH',
            'vehicle_type' => 'Cargo',
            'fuel_consumption' => 12.0,
            'availability_status' => true,
            'region' => 'Branch Office',
            'ownership' => 'Rented',
            'last_service_date' => now()->subMonths(6),
            'next_service_date' => now()->addMonths(2),
            'usage_start_date' => now()->subWeek(),
            'usage_end_date' => now()->addWeek(),
        ]);

        Vehicle::create([
            'plate_number' => 'IJ789KL',
            'vehicle_type' => 'Passenger',
            'fuel_consumption' => 6.0,
            'availability_status' => false,
            'region' => 'Mine 1',
            'ownership' => 'Company-owned',
            'last_service_date' => now()->subMonths(1),
            'next_service_date' => now()->addMonth(),
            'usage_start_date' => now()->subDays(10),
            'usage_end_date' => now()->addDays(2),
        ]);

        Vehicle::create([
            'plate_number' => 'MN012OP',
            'vehicle_type' => 'Cargo',
            'fuel_consumption' => 15.5,
            'availability_status' => true,
            'region' => 'Mine 3',
            'ownership' => 'Rented',
            'last_service_date' => now()->subMonths(2),
            'next_service_date' => now()->addMonths(4),
            'usage_start_date' => now()->subDays(5),
            'usage_end_date' => now()->addDays(3),
        ]);
    }
}

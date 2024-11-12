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
            'name' => 'Truck 1',
            'type' => 'Goods Transport',
            'plate_number' => 'B 1234 ABC',
        ]);

        Vehicle::create([
            'name' => 'Van 1',
            'type' => 'Passenger Transport',
            'plate_number' => 'B 5678 XYZ',
        ]);

        Vehicle::create([
            'name' => 'SUV 1',
            'type' => 'Passenger Transport',
            'plate_number' => 'B 9101 DEF',
        ]);
    }
}

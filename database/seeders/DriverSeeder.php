<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $driverCount = 10;

        for ($i = 0; $i < $driverCount; $i++) {
            Driver::create([
                'name' => fake()->name('male'),
                'license_number' => strtoupper(fake()->bothify('??#######')),
                'phone_number' => fake()->phoneNumber(),
            ]);
        }
    }
}

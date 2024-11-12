<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => 'password', // Please secure this password in a real application
            'role' => 'admin',
        ]);

        // Approver users
        User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@email.com',
            'password' => 'password',
            'role' => 'approver',
        ]);

        User::create([
            'name' => 'Supervisor2',
            'email' => 'supervisor2@email.com',
            'password' => 'password',
            'role' => 'approver',
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@email.com',
            'password' => 'password',
            'role' => 'approver',
        ]);
    }
}

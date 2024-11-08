<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('admin');

        $supervisor = User::create([
            'name' => 'Jack',
            'email' => 'jack@email.com',
            'password' => Hash::make('password')
        ]);
        $supervisor->assignRole('supervisor');

        $manager = User::create([
            'name' => 'Erik Tohir',
            'email' => 'erik@email.com',
            'password' => Hash::make('password')
        ]);
        $manager->assignRole('manager');

        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('driver');
        });
    }
}

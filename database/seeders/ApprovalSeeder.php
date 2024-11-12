<?php

namespace Database\Seeders;

use App\Models\Approval;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = Booking::all();
        $approvers = User::where('role', 'approver')->get();

        foreach ($bookings as $booking) {
            $approver1 = $approvers->random();
            $approver2 = $approvers->random();

            // Level 1 Approval
            Approval::create([
                'booking_id' => $booking->id,
                'approver_id' => $approver1->id,
                'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
                'level' => 1,
            ]);

            // Level 2 Approval
            Approval::create([
                'booking_id' => $booking->id,
                'approver_id' => $approver2->id,
                'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
                'level' => 2,
            ]);
        }
    }
}

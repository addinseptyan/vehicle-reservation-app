<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('supervisor') || $user->hasRole('manager');
    }

    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Reservation $reservation)
    {
        return $user->hasRole('supervisor') || $user->hasRole('manager') && $user->id === $reservation->approver_id;
    }

    public function approveAsSupervisor(User $user, Reservation $reservation)
    {
        // Define the logic to check if the user can approve as supervisor
        return $user->hasRole('supervisor') && $reservation->approved_by_supervisor === 'pending';
    }

    public function approveAsManager(User $user, Reservation $reservation)
    {
        // Define the logic to check if the user can approve as manager
        return $user->hasRole('manager') && $reservation->approved_by_manager === 'pending';
    }
}

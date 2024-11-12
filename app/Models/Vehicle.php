<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function usageRecords(): HasMany
    {
        return $this->hasMany(VehicleUsage::class);
    }
}

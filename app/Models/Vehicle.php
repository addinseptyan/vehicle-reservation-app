<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'vehicle_type',
        'fuel_consumption',
        'availability_status',
        'region',
        'ownership',
        'last_service_date',
        'next_service_date',
        'usage_start_date',
        'usage_end_date',
    ];
}

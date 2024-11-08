<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'driver_id',
        'approver_id',
        'approver_level2_id',
        'reservation_status',
        'usage_start',
        'usage_end',
        'approved_by_supervisor',
        'approved_by_manager',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function approverLevel2()
    {
        return $this->belongsTo(User::class, 'approver_level2_id');
    }

    public function approvalLogs()
    {
        return $this->hasMany(ApprovalLog::class);
    }

    public function checkApprovalStatus()
    {
        // Check if both approvers have approved the reservation
        if ($this->approved_by_supervisor === 'approved' && $this->approved_by_manager === 'approved') {
            $this->update(['reservation_status' => 'approved']);
        } else if ($this->approved_by_supervisor === 'rejected' || $this->approved_by_manager === 'rejected') {
            $this->update(['reservation_status' => 'rejected']);
        } else {
            $this->update(['reservation_status' => 'pending']);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Approval extends Model
{
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function canApprove()
    {
        $previousApproval = Approval::where('booking_id', $this->booking_id)
            ->where('level', '<', $this->level)
            ->where('status', 'pending')
            ->first();

        return $previousApproval === null;
    }
}

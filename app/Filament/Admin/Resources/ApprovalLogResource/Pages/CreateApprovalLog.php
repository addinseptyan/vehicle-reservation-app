<?php

namespace App\Filament\Admin\Resources\ApprovalLogResource\Pages;

use App\Filament\Admin\Resources\ApprovalLogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateApprovalLog extends CreateRecord
{
    protected static string $resource = ApprovalLogResource::class;
}

<?php

namespace App\Filament\Admin\Resources\ApprovalLogResource\Pages;

use App\Filament\Admin\Resources\ApprovalLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovalLog extends EditRecord
{
    protected static string $resource = ApprovalLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

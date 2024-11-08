<?php

namespace App\Filament\Admin\Resources\ApprovalLogResource\Pages;

use App\Filament\Admin\Resources\ApprovalLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApprovalLogs extends ListRecords
{
    protected static string $resource = ApprovalLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}

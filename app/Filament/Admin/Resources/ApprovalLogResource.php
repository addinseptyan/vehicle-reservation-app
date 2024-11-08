<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ApprovalLogResource\Pages;
use App\Filament\Admin\Resources\ApprovalLogResource\RelationManagers;
use App\Models\ApprovalLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApprovalLogResource extends Resource
{
    protected static ?string $model = ApprovalLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reservation.vehicle.plate_number')->label('Reservation Plate Number'),
                TextColumn::make('approver.name')->label('Approver'),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'danger' => 'rejected',
                        'success' => 'approved',
                        'warning' => 'pending',
                    ]),
                TextColumn::make('approval_at')->label('Approval Time')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovalLogs::route('/'),
            // 'create' => Pages\CreateApprovalLog::route('/create'),
            // 'edit' => Pages\EditApprovalLog::route('/{record}/edit'),
        ];
    }
}

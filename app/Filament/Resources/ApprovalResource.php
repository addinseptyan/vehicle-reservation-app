<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovalResource\Pages;
use App\Filament\Resources\ApprovalResource\RelationManagers;
use App\Models\Approval;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApprovalResource extends Resource
{
    protected static ?string $model = Approval::class;

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
                TextColumn::make('booking_id'),
                TextColumn::make('booking.vehicle.plate_number'),
                TextColumn::make('booking.vehicle.name'),
                TextColumn::make('booking.driver.name'),
                TextColumn::make('booking.start_time'),
                TextColumn::make('booking.end_time'),
                TextColumn::make('approver.name')->label('Approver Name'),
                TextColumn::make('level')->label('Approver Level'),
                TextColumn::make('status')->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
            ])
            ->filters([
                SelectFilter::make('approver')
                    ->relationship('approver', 'name')
            ])
            ->actions([
                // Tables\Actions\EditAction::make()
                //     ->visible(fn($record) => $record->approver->name == auth()->user()->name),

                Action::make('Approve')
                    ->action(function ($record) {
                        if ($record->canApprove()) {
                            $record->status = 'approved';
                            $record->save();
                        } else {
                            Notification::make()
                                ->title('Action Not Executed')
                                ->body('The previous approver has not yet approved this request. Please wait for their approval before proceeding.')
                                ->danger()
                                ->send();
                        }
                    })
                    ->color('success')
                    ->visible(fn($record) => $record->approver->name == auth()->user()->name || auth()->user()->role == 'admin'),
                Action::make('Reject')
                    ->action(function ($record) {
                        if ($record->canApprove()) {
                            $record->status = 'rejected';
                            $record->save();
                        } else {
                            Notification::make()
                                ->title('Action Not Executed')
                                ->body('The previous approver has not yet approved this request. Please wait for their approval before proceeding.')
                                ->danger()
                                ->send();
                        }
                    })
                    ->color('danger')
                    ->visible(fn($record) => $record->approver->name == auth()->user()->name || auth()->user()->role == 'admin'),
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
            'index' => Pages\ListApprovals::route('/'),
            // 'create' => Pages\CreateApproval::route('/create'),
            // 'edit' => Pages\EditApproval::route('/{record}/edit'),
        ];
    }
}

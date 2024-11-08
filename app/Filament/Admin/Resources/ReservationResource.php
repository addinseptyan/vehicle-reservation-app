<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ReservationResource\Pages;
use App\Filament\Admin\Resources\ReservationResource\RelationManagers;
use App\Models\ApprovalLog;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Select Vehicle for Reservation
                Select::make('vehicle_id')
                    ->label('Vehicle')
                    ->options(Vehicle::all()->pluck('plate_number', 'id'))
                    ->required(),

                // Select User (who makes the reservation)
                Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required(),

                // Select Driver
                Select::make('driver_id')
                    ->label('Driver')
                    ->options(User::role('driver')->pluck('name', 'id'))
                    ->nullable(),

                // Select First-level Approver
                Select::make('approver_id')
                    ->label('1st Approver (Supervisor)')
                    ->options(User::role('supervisor')->pluck('name', 'id'))
                    ->required(),

                // Select Second-level Approver (optional)
                Select::make('approver_level2_id')
                    ->label('2nd Approver (Manager)')
                    ->options(User::role('manager')->pluck('name', 'id'))
                    ->nullable(),

                // Reservation Start Date and Time
                DateTimePicker::make('usage_start')
                    ->label('Reservation Start')
                    ->required(),

                // Reservation End Date and Time
                DateTimePicker::make('usage_end')
                    ->label('Reservation End')
                    ->required(),

                // Status (Pending, Approved, Rejected)
                Select::make('reservation_status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicle.plate_number')
                    ->label('Vehicle')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('driver.name')
                    ->label('Driver')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('approver.name')
                    ->label('Supervisor')
                    ->sortable(),

                TextColumn::make('approverLevel2.name')
                    ->label('Manager')
                    ->sortable(),

                TextColumn::make('usage_start')
                    ->label('Start Time')
                    ->sortable()
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->toDateTimeString()),

                TextColumn::make('usage_end')
                    ->label('End Time')
                    ->sortable()
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->toDateTimeString()),

                TextColumn::make('reservation_status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'danger' => 'rejected',
                        'success' => 'approved',
                        'warning' => 'pending',
                    ])
                    ->sortable(),

                TextColumn::make('approved_by_supervisor')
                    ->label('Approval (Supervisor)')
                    ->badge()
                    ->colors([
                        'danger' => 'rejected',
                        'success' => 'approved',
                        'warning' => 'pending',
                    ]),

                TextColumn::make('approved_by_manager')
                    ->label('Approval (Manager)')
                    ->badge()
                    ->colors([
                        'danger' => 'rejected',
                        'success' => 'approved',
                        'warning' => 'pending',
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approveAsSupervisor')
                    ->label('Approve as Supervisor')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => auth()->user()->can('approveAsSupervisor', $record))
                    ->action(function ($record) {
                        $record->update(['approved_by_supervisor' => 'approved']);
                        $record->checkApprovalStatus();
                        ApprovalLog::create([
                            'reservation_id' => $record->id,
                            'approver_id' => auth()->id(),
                            'status' => 'approved',
                            'approval_at' => now(),
                        ]);
                    }),

                Tables\Actions\Action::make('rejectAsSupervisor')
                    ->label('Reject')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->visible(fn($record) => auth()->user()->can('approveAsSupervisor', $record))
                    ->action(function ($record) {
                        $record->update(['approved_by_supervisor' => 'rejected']);
                        $record->checkApprovalStatus();
                        ApprovalLog::create([
                            'reservation_id' => $record->id,
                            'approver_id' => auth()->id(),
                            'status' => 'rejected',
                            'approval_at' => now(),
                        ]);
                    }),

                Tables\Actions\Action::make('approveAsManager')
                    ->label('Approve as Manager')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => auth()->user()->can('approveAsManager', $record))
                    ->action(function ($record) {
                        $record->update(['approved_by_manager' => 'approved']);
                        $record->checkApprovalStatus();
                        ApprovalLog::create([
                            'reservation_id' => $record->id,
                            'approver_id' => auth()->id(),
                            'status' => 'approved',
                            'approval_at' => now(),
                        ]);
                    }),

                Tables\Actions\Action::make('rejectAsManager')
                    ->label('Reject')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->visible(fn($record) => auth()->user()->can('approveAsManager', $record))
                    ->action(function ($record) {
                        $record->update(['approved_by_manager' => 'rejected']);
                        $record->checkApprovalStatus();
                        ApprovalLog::create([
                            'reservation_id' => $record->id,
                            'approver_id' => auth()->id(),
                            'status' => 'rejected',
                            'approval_at' => now(),
                        ]);
                    }),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}

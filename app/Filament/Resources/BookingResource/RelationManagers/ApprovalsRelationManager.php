<?php

namespace App\Filament\Resources\BookingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApprovalsRelationManager extends RelationManager
{
    protected static string $relationship = 'approvals';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('approver_id')->relationship('approver', 'name')->required(),
                Select::make('level')->options([
                    '1' => '1',
                    '2' => '2',
                ])->required(),
                Select::make('status')->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])->default('pending'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('approver.name')->label('Approver Name'),
                TextColumn::make('level'),
                TextColumn::make('status')->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('Approve')->action(function ($record) {
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
                })->color('success'),
                Action::make('Reject')->action(function ($record) {
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
                })->color('danger'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

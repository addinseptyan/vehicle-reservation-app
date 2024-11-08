<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\VehicleResource\Pages;
use App\Filament\Admin\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('plate_number')
                    ->label('Plate Number')
                    ->unique()
                    ->required()
                    ->helperText('Unique plate number of the vehicle.'),

                Select::make('vehicle_type')
                    ->label('Vehicle Type')
                    ->options([
                        'Passenger' => 'Passenger',
                        'Cargo' => 'Cargo',
                    ])
                    ->required()
                    ->placeholder('Select Vehicle Type'),

                TextInput::make('fuel_consumption')
                    ->label('Fuel Consumption')
                    ->numeric()
                    ->required()
                    ->suffix('L/km')
                    ->helperText('Enter fuel consumption in liters per kilometer.'),

                Select::make('availability_status')
                    ->label('Availability')
                    ->options([
                        true => 'Available',
                        false => 'Not Available',
                    ])
                    ->default(true),

                Select::make('region')
                    ->label('Region')
                    ->options([
                        'HQ' => 'Headquarters',
                        'Branch Office' => 'Branch Office',
                        'Mine 1' => 'Mine 1',
                        'Mine 2' => 'Mine 2',
                        'Mine 3' => 'Mine 3',
                        'Mine 4' => 'Mine 4',
                        'Mine 5' => 'Mine 5',
                        'Mine 6' => 'Mine 6',
                    ])
                    ->required(),

                Select::make('ownership')
                    ->label('Ownership')
                    ->options([
                        'Company-owned' => 'Company-owned',
                        'Rented' => 'Rented'
                    ])
                    ->required(),

                DatePicker::make('last_service_date')
                    ->label('Last Service Date'),

                DatePicker::make('next_service_date')
                    ->label('Next Service Date')
                    ->required()
                    ->helperText('The scheduled date for the next service.'),

                DatePicker::make('usage_start_date')
                    ->label('Usage Start Date'),

                DatePicker::make('usage_end_date')
                    ->label('Usage End Date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Column for Vehicle Plate Number
                TextColumn::make('plate_number')
                    ->label('Plate Number')
                    ->sortable()
                    ->searchable()
                    ->limit(30),

                // Column for Vehicle Type (e.g., Passenger or Cargo)
                TextColumn::make('vehicle_type')
                    ->label('Vehicle Type')
                    ->sortable()
                    ->searchable()
                    ->limit(20),

                // Column for Fuel Consumption (L/km)
                TextColumn::make('fuel_consumption')
                    ->label('Fuel Consumption (L/km)')
                    ->sortable()
                    ->numeric()
                    ->limit(20),

                // Column for Availability Status (Available/Not Available)
                IconColumn::make('availability_status')
                    ->boolean()
                    ->label('Availability')
                    ->sortable(),

                // Column for Region (Where the vehicle is located)
                TextColumn::make('region')
                    ->label('Region')
                    ->sortable()
                    ->limit(20),

                // Column for Ownership (Company-owned or Rented)
                TextColumn::make('ownership')
                    ->label('Ownership')
                    ->sortable()
                    ->limit(20),

                // Column for Last Service Date
                TextColumn::make('last_service_date')
                    ->label('Last Service Date')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state ? \Carbon\Carbon::parse($state)->toDateString() : '-'),

                // Column for Next Service Date (Scheduled)
                TextColumn::make('next_service_date')
                    ->label('Next Service Date')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state ? \Carbon\Carbon::parse($state)->toDateString() : '-'),

                // Column for Usage Start Date
                TextColumn::make('usage_start_date')
                    ->label('Usage Start Date')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state ? \Carbon\Carbon::parse($state)->toDateString() : '-'),

                // Column for Usage End Date
                TextColumn::make('usage_end_date')
                    ->label('Usage End Date')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state ? \Carbon\Carbon::parse($state)->toDateString() : '-'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}

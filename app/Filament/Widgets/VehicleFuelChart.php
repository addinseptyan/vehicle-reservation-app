<?php

namespace App\Filament\Widgets;

use App\Models\Vehicle;
use Filament\Widgets\ChartWidget;

class VehicleFuelChart extends ChartWidget
{
    protected static ?string $heading = 'Vehicle Fuel Chart';

    protected function getData(): array
    {
        $vehicles = Vehicle::with('usageRecords')->get();

        $vehicleNames = $vehicles->pluck('name')->toArray();
        $vehicleFuels = $vehicles->map(function ($vehicle) {
            return $vehicle->usageRecords->sum('fuel_consumed');
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Vehicle fuel comsumed',
                    'data' => $vehicleFuels,
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                ]
            ],
            'labels' => $vehicleNames,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

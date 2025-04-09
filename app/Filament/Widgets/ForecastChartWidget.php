<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ForecastChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $ordersData = Order::selectRaw('DATE(created_at) as date, SUM(quantity) as quantity')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $jsonData = json_encode($ordersData);
        $filePath = storage_path('app/forecast_data.json');
        file_put_contents($filePath, $jsonData);

        $process = new Process(['python3', base_path('forecast.py'), $filePath]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $forecast = json_decode($process->getOutput(), true);

        $labels = array_map(fn($i) => "Day $i", range(1, count($ordersData)));

        $realData = $ordersData->pluck('quantity')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Реальные заказы',
                    'data' => $realData,
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'fill' => true,
                ],
                [
                    'label' => 'Прогнозируемое количество заказов',
                    'data' => $forecast,
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'fill' => true,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

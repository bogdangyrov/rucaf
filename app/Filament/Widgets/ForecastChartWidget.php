<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Select;
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

        $process = new Process([base_path('.venv/bin/python3'), base_path('forecast.py'), $filePath]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $forecastRaw = json_decode($process->getOutput(), true);
        $realData = $ordersData->pluck('quantity')->toArray();

        // добавляем null перед прогнозом, чтобы он шел после реальных данных
        $forecast = array_merge(array_fill(0, count($realData), null), $forecastRaw);

        $labels = array_map(fn($date) => $date['date'], $ordersData->toArray());
        $forecastLabels = array_map(fn($i) => 'Прогноз ' . ($i + 1), range(0, count($forecastRaw) - 1));
        $labels = array_merge($labels, $forecastLabels);

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

    public static function getFormSchema(): array
    {
        return [
            Select::make('period')
                ->label('Период прогноза')
                ->options([
                    '30' => '1 месяц',
                    '90' => '3 месяца',
                    '180' => '6 месяцев',
                ])
                ->default('30'),
        ];
    }
}

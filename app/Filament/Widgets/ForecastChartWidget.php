<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Subcategory;
use Filament\Forms\Components\Select;
use Symfony\Component\Process\Process;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;

class ForecastChartWidget extends ApexChartWidget
{
    protected static ?string $heading = 'Прогноз заказов';

    protected int | string | array $columnSpan = 'full';

    protected function getOptions(): array
    {
        $period = $this->filterFormData['period'] ?? '1';
        $displayMonths = $this->filterFormData['display_months'];

        $ordersData = $this->getOrdersData();
        $forecastData = $this->getForecastData($ordersData, $period);

        $trimmedData = $this->trimData($ordersData, $displayMonths, $period);

        $realData = $this->getRealData($trimmedData);
        $labels = $this->generateLabels($trimmedData, $forecastData);

        return $this->buildChartOptions($realData, $forecastData, $labels);
    }

    private function trimData($data, $displayMonths, $period)
    {
        if ($displayMonths === 'all') {
            return $data;
        } else {
            return $data->take(-$displayMonths + $period);
        }
    }

    private function getOrdersData()
    {
        $selectedProduct = $this->filterFormData['subcategory'];

        $query = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(quantity) as quantity')
            ->groupBy('month')
            ->orderBy('month');

        if ($selectedProduct) {
            $query->where('subcategory_id', $selectedProduct);
        }

        return $query->get();
    }

    private function getRealData($ordersData)
    {
        return array_map('intval', $ordersData->pluck('quantity')->toArray());
    }

    private function getForecastData($ordersData, $period)
    {
        $filePath = storage_path('app/forecast_data.json');
        file_put_contents($filePath, json_encode($ordersData));

        $process = new Process(['python3', base_path('forecast.py'), $filePath, $period]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $forecastRaw = json_decode($process->getOutput(), true);
        return array_map('intval', $forecastRaw);
    }

    private function generateLabels($ordersData, $forecastData)
    {
        $labels = array_map(
            fn($date) => Carbon::createFromFormat('Y-m', $date['month'])->locale('ru')->translatedFormat('F Y'),
            $ordersData->toArray()
        );

        $lastMonth = Carbon::createFromFormat('Y-m', $ordersData->last()['month']);
        $forecastLabels = [];
        for ($i = 1; $i <= count($forecastData); $i++) {
            $forecastLabels[] = $lastMonth->addMonth()->locale('ru')->translatedFormat('F Y');
        }

        return array_merge($labels, $forecastLabels);
    }

    private function buildChartOptions($realData, $forecastData, $labels)
    {
        $forecast = array_merge(array_fill(0, count($realData), null), $forecastData);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 350,
            ],
            'series' => [
                [
                    'name' => 'Реальные заказы',
                    'data' => $realData,
                ],
                [
                    'name' => 'Прогнозируемое количество заказов',
                    'data' => $forecast,
                ],
            ],
            'xaxis' => [
                'categories' => $labels,
            ],
            'colors' => ['#4BC0C0', '#FF6384'],
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('period')
                ->label('Период прогноза')
                ->options([
                    '1' => '1 Месяц',
                    '3' => '3 Месяца',
                    '6' => '6 Месяцев',
                ])
                ->default('1')
                ->reactive(),
            Select::make('display_months')
                ->label('Количество отображаемых месяцев')
                ->options([
                    '12' => '12 месяцев',
                    '24' => '24 месяца',
                    'all' => 'Все'
                ])
                ->default('12')
                ->reactive(),
            Select::make('subcategory')
                ->label('Товар')
                ->getSearchResultsUsing(fn(string $search): array => Subcategory::where('name', 'like', "%{$search}%")->limit(10)->pluck('name', 'id')->toArray())
                ->getOptionLabelUsing(fn($value): ?string => Subcategory::find($value)?->name)
                ->searchable()
                ->default(Subcategory::first()->id)
                ->reactive(),
        ];
    }
}

<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Subcategory;
use Filament\Forms\Components\Select;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Services\ForecastService;

class ForecastChartWidget extends ApexChartWidget
{
    protected static ?string $heading = 'Прогноз заказов';

    protected int | string | array $columnSpan = 'full';

    private ForecastService $forecastService;

    public function __construct()
    {
        $this->forecastService = new ForecastService();
    }

    protected function getPollingInterval(): ?string
    {
        return null;
    }

    protected function getOptions(): array
    {
        $period = $this->filterFormData['period'];
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

        $ordersData = $query->get();

        if ($ordersData->isEmpty()) {
            return collect([['month' => now()->format('Y-m'), 'quantity' => 0]]);
        }

        return $ordersData;
    }

    private function getRealData($ordersData)
    {
        return array_map('intval', $ordersData->pluck('quantity')->toArray());
    }

    private function getForecastData($ordersData, $period)
    {
        return $this->forecastService->getForecastData($ordersData, $period);
    }

    private function generateLabels($ordersData, $forecastData)
    {
        $labels = array_map(
            fn($date) => Carbon::createFromFormat('Y-m', $date['month'])->locale('ru')->translatedFormat('F Y'),
            $ordersData->toArray()
        );

        $currentMonth = Carbon::now()->startOfMonth();
        $forecastLabels = [];
        for ($i = 0; $i < count($forecastData); $i++) {
            $forecastLabels[] = $currentMonth->copy()->addMonths($i)->locale('ru')->translatedFormat('F Y');
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
                ->default('1'),
            Select::make('display_months')
                ->label('Количество отображаемых месяцев')
                ->options([
                    '12' => '12 месяцев',
                    '24' => '24 месяца',
                    'all' => 'Все'
                ])
                ->default('12'),
            Select::make('subcategory')
                ->label('Товар')
                ->getSearchResultsUsing(
                    fn(string $search): array => Subcategory::where('name', 'like', "%{$search}%")
                        ->limit(10)->pluck('name', 'id')->toArray()
                )
                ->getOptionLabelUsing(fn($value): ?string => Subcategory::find($value)?->name)
                ->default(Subcategory::first()->id)
                ->searchable()
                ->reactive(),
        ];
    }
}

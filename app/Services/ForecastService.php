<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ForecastService
{
    private array $forecastCache = [];

    public function getForecastData($ordersData, $period): array
    {
        $cacheKey = $this->generateCacheKey($ordersData, $period);

        if ($cachedData = $this->getCachedForecast($cacheKey)) {
            return $cachedData;
        }

        $forecastData = $this->runForecast($ordersData, $period);

        $this->cacheForecast($cacheKey, $forecastData);

        return $forecastData;
    }

    private function generateCacheKey($ordersData, $period): string
    {
        return 'forecast_' . md5(json_encode($ordersData) . '_' . $period);
    }

    private function getCachedForecast(string $cacheKey): ?array
    {
        if (isset($this->forecastCache[$cacheKey])) {
            return $this->forecastCache[$cacheKey];
        }

        if (cache()->has($cacheKey)) {
            $cached = cache()->get($cacheKey);
            $this->forecastCache[$cacheKey] = $cached;
            return $cached;
        }

        return null;
    }

    private function runForecast($ordersData, $period): array
    {
        $filePath = storage_path('app/forecast_data.json');
        file_put_contents($filePath, json_encode($ordersData));

        $process = new Process(['python3', base_path('forecast.py'), $filePath, $period]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return array_map('intval', json_decode($process->getOutput(), true));
    }

    private function cacheForecast(string $cacheKey, array $forecastData): void
    {
        cache()->put($cacheKey, $forecastData, 6000);
        $this->forecastCache[$cacheKey] = $forecastData;
    }
}

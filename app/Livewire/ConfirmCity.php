<?php

namespace App\Livewire;

use App\Services\CustomerService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ConfirmCity extends Component
{
    private const DEFAULT_CITY = 'Санкт-Петербург';

    public ?string $city = null;

    public ?string $detectedCity = null;

    public function mount(): void
    {
        $this->city = CustomerService::getCity();

        if ($this->city) {
            return;
        }

        $this->detectCity();
    }

    private function detectCity(): void
    {
        $ip = request()->ip();

        if (!$ip) {
            $this->detectedCity = self::DEFAULT_CITY;

            return;
        }

        if (request()->hasHeader('User-Agent') && preg_match('/(bot|crawl|slurp|spider|mediapartners)/i', request()->header('User-Agent'))) {
            $this->detectedCity = self::DEFAULT_CITY;
            return;
        }

        $ip = request()->ip();

        if (!$ip || !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            $this->detectedCity = self::DEFAULT_CITY;
            return;
        }

        $cacheKey = 'city_by_ip:' . $ip;

        $cachedCity = Cache::get($cacheKey);

        if ($cachedCity) {
            $this->detectedCity = $cachedCity;

            return;
        }

        try {
            $response = Http::timeout(3)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Token ' . config('services.dadata.token'),
                ])
                ->post(
                    'https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address',
                    [
                        'ip' => $ip,
                    ]
                );

            if (!$response->successful()) {
                $this->detectedCity = self::DEFAULT_CITY;

                return;
            }

            $detectedCity = $response->json('location.data.city');

            Log::info('Get city for ip: ' . $ip);

            if (!$detectedCity) {
                $this->detectedCity = self::DEFAULT_CITY;

                return;
            }

            Cache::put(
                $cacheKey,
                $detectedCity,
                now()->addDays(30)
            );

            $this->detectedCity = $detectedCity;
        } catch (\Throwable $e) {
            Log::error('Failed to fetch city from DaData', [
                'ip' => $ip,
                'message' => $e->getMessage(),
            ]);

            $this->detectedCity = self::DEFAULT_CITY;
        }
    }

    public function confirm(): void
    {
        if (!$this->detectedCity) {
            return;
        }

        CustomerService::addCity($this->detectedCity);

        $this->city = $this->detectedCity;

        $this->dispatch('cityUpdated');
    }

    public function render()
    {
        return view('livewire.confirm-city');
    }
}

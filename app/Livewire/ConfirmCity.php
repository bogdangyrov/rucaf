<?php

namespace App\Livewire;

use App\Services\CustomerService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ConfirmCity extends Component
{
    private const DEFAULT_CITY = 'Санкт-Петербург';

    public ?string $city = null;

    public function mount(): void
    {
        $this->city = CustomerService::getCity();

        if (!$this->city) {
            $this->detectCity();
        }
    }

    private function detectCity(): void
    {
        try {
            $ip = request()->ip();
            Log::info('Detecting city for IP', ['ip' => $ip]);

            Log::info('IP debug', [
                'request_ip' => request()->ip(),
                'remote_addr' => $_SERVER['REMOTE_ADDR'] ?? null,
                'x_forwarded_for' => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null,
                'x_real_ip' => $_SERVER['HTTP_X_REAL_IP'] ?? null,
                'cf_connecting_ip' => $_SERVER['HTTP_CF_CONNECTING_IP'] ?? null,
            ]);

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

            if ($response->successful()) {
                $this->city = $response->json('location.data.city')
                    ?: self::DEFAULT_CITY;
            } else {
                $this->city = self::DEFAULT_CITY;
            }

            Log::info('Detected city', [
                'ip' => $ip,
                'city' => $this->city,
                'response' => $response->json(),
            ]);
        } catch (\Throwable $e) {
            $this->city = self::DEFAULT_CITY;

            Log::error('Failed to fetch city from DaData', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function confirm(): void
    {
        if (!$this->city) {
            return;
        }

        CustomerService::addCity($this->city);

        $this->dispatch('cityUpdated');
    }

    public function render()
    {
        return view('livewire.confirm-city');
    }
}

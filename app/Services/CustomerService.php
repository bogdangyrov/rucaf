<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public const DEFAULT_CITY = 'Санкт-Петербург';

    public static function addCity($name)
    {
        return session(['city' => $name]);
    }

    public static function getCity()
    {
        return session('city');
    }

    public static function getCityWithDetection()
    {
        if ($city = self::getCity()) {
            return $city;
        }

        if (self::isBot()) {
            return self::DEFAULT_CITY;
        }

        $ip = request()->ip();

        if (!$ip || !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return self::DEFAULT_CITY;
        }

        $cacheKey = 'city_by_ip:' . $ip;

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey) ?: self::DEFAULT_CITY;
        }

        try {
            $response = Http::timeout(3)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Token ' . config('services.dadata.token'),
                ])
                ->post('https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address', [
                    'ip' => $ip,
                ]);

            if (!$response->successful()) {
                Cache::put($cacheKey, self::DEFAULT_CITY, now()->addDays(30));
                return self::DEFAULT_CITY;
            }

            $detectedCity = $response->json('location.data.city');

            Log::info('Get city for ip: ' . $ip);

            if (!$detectedCity) {
                Cache::put($cacheKey, self::DEFAULT_CITY, now()->addDays(30));
                return self::DEFAULT_CITY;
            }

            Cache::put($cacheKey, $detectedCity, now()->addDays(30));
            return $detectedCity;
        } catch (\Throwable $e) {
            Log::error('Failed to fetch city from DaData', [
                'ip' => $ip,
                'message' => $e->getMessage(),
            ]);

            return self::DEFAULT_CITY;
        }
    }

    private static function isBot(): bool
    {
        $userAgent = request()->header('User-Agent');

        if (!$userAgent) {
            return true;
        }

        $botPattern = '/(googlebot|yandex|bingbot|slurp|duckduckbot|baiduspider|sogou|exabot|facebot|facebookexternalhit|ia_archiver|curl|python|wget|bot|crawl|spider|seeker|preview)/i';

        return (bool) preg_match($botPattern, $userAgent);
    }
}

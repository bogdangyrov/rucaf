<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class GlobalCacheObserver
{
    /**
     * Срабатывает при создании или обновлении записи
     */
    public function saved($model): void
    {
        $this->clearCache();
    }

    /**
     * Срабатывает при удалении записи
     */
    public function deleted($model): void
    {
        $this->clearCache();
    }

    /**
     * Очистка глобальных ключей кэша ViewComposerProvider
     */
    protected function clearCache(): void
    {
        Cache::forget('global_shared_data');
        Cache::forget('global_catalog_menu');
        Cache::forget('global_cities_grouped');
    }
}
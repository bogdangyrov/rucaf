<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('queue:work --stop-when-empty --tries=3')->everyFiveMinutes();

Schedule::command('app:generate-sitemap')->cron('0 3 */3 * *')
    ->withoutOverlapping()
    ->sendOutputTo(storage_path('logs/sitemap.log'));

Schedule::command('backup:clean')->daily()->at('03:00');
Schedule::command('backup:run')->daily()->at('03:30');

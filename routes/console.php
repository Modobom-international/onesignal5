<?php

use App\Console\Commands\LogBehavior\NotifyTelegramInstallLogBehavior;
use App\Console\Commands\LogBehavior\TransDataForOldYear;
use App\Console\Commands\FillUrlForPushSystem;
use App\Console\Commands\Domains\CheckDomain;
use App\Console\Commands\LogBehavior\SyncOldData;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Artisan;

Schedule::command('horizon:snapshot')->everyFiveMinutes();
Schedule::command('telescope:prune')->daily();
Schedule::command('horizon:clear-log')->monthlyOn(1, '00:00');

Schedule::command(NotifyTelegramInstallLogBehavior::class)->everyMinute();
Schedule::command(CheckDomain::class)->everyMinute();
Schedule::command(FillUrlForPushSystem::class)->dailyAt('00:00');
Schedule::command(TransDataForOldYear::class)->yearly();

Schedule::command(SyncOldData::class)
    ->dailyAt('00:00')
    ->then(function () {
        $exitCode = Artisan::call('log-behavior:sync-old-data', [], new \Symfony\Component\Console\Output\NullOutput());
        if ($exitCode === 0) {
            Artisan::call('log-behavior:cache-data-per-date');
        } else {
            \Log::error('log-behavior:sync-old-data run failed, log-behavior:cache-data-per-date');
        }
    });

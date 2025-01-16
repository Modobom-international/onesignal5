<?php

use App\Console\Commands\LogBehavior\NotifyTelegramInstallLogBehavior;
use App\Console\Commands\LogBehavior\SyncOldData;
use App\Console\Commands\LogBehavior\CacheDataPerDate;
use App\Console\Commands\LogBehavior\TransDataForOldYear;
use App\Console\Commands\FillUrlForPushSystem;

Schedule::command('horizon:snapshot')->everyFiveMinutes();
Schedule::command(NotifyTelegramInstallLogBehavior::class)->everyMinute();
Schedule::command('telescope:prune')->daily();
Schedule::command(CacheDataPerDate::class)->dailyAt('00:00')->onSuccess(function () {
    Schedule::command(SyncOldData::class)->runInBackground();
});;
Schedule::command(FillUrlForPushSystem::class)->dailyAt('00:00');
Schedule::command(TransDataForOldYear::class)->yearly();

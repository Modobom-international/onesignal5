<?php

use App\Console\Commands\LogBehavior\NotifyTelegramInstallLogBehavior;
use App\Console\Commands\LogBehavior\TransDataForOldYear;
use App\Console\Commands\FillUrlForPushSystem;
use App\Console\Commands\Domains\CheckDomain;

Schedule::command('horizon:snapshot')->everyFiveMinutes();
Schedule::command('telescope:prune')->daily();
Schedule::command('horizon:clear-log')->monthlyOn(1, '00:00');

Schedule::command(NotifyTelegramInstallLogBehavior::class)->everyMinute();
Schedule::command(CheckDomain::class)->everyMinute();
Schedule::command(FillUrlForPushSystem::class)->dailyAt('00:00');
Schedule::command(TransDataForOldYear::class)->yearly();

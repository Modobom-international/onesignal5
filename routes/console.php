<?php

use App\Console\Commands\FillUrlForPushSystem;

Schedule::command('horizon:snapshot')->everyFiveMinutes();
Schedule::command('telescope:prune')->daily();
Schedule::command(FillUrlForPushSystem::class)->dailyAt('00:00');

<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CustomHorizonLogger
{
    public function __invoke(array $config)
    {
        return new Logger('horizon', [
            new StreamHandler(
                storage_path('logs/horizon.log'),
                Logger::INFO
            ),
        ]);
    }
}

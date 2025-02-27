<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearHorizonLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'horizon:clear-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Horizon clear log';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logFile = storage_path('logs/horizon.log');

        if (file_exists($logFile)) {
            file_put_contents($logFile, '');
            $this->info('File horizon.log đã được xóa nội dung.');
        } else {
            $this->warn('File horizon.log không tồn tại.');
        }
    }
}

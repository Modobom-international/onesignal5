<?php

namespace App\Console\Commands\TestCommand;

use Illuminate\Console\Command;
use App\Events\NotificationSystem;

class TestLogic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $url;
    protected $signature = 'test:logic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        broadcast(new NotificationSystem(
            [
                'message' => 'Domain: đã hoạt động',
                'users_id'  => 1
            ],
        ));
    }
}

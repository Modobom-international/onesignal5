<?php

namespace App\Console\Commands\TestCommand;

use Illuminate\Console\Command;
use App\Services\GoDaddyService;
use Auth;

class TestOther extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $url;
    protected $signature = 'test:other';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test other command';

    /**
     * Execute the console command.
     */
    public function handle()
    {

    }
}

<?php

namespace App\Console\Commands\TestCommand;

use Illuminate\Console\Command;
use DB;

class TestConnectDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:connect-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Connect db';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = DB::table('users')->get();

        dump($users);
    }
}

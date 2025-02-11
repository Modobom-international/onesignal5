<?php

namespace App\Console\Commands\TestCommand;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

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
        $pass = Hash::make('123456789As', ['rounds' => 10]);
        dd($pass);
    }
}

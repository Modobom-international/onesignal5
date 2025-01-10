<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BinhTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:binh-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = '5886aaac-2ad5-4636-9781-c05f7a926b3f';
        $getDB = DB::connection('mongodb')->table('log_behavior_history')->get();

        var_dump($getDB);
    }
}

<?php

namespace App\Console\Commands\LogBehavior;

use Illuminate\Console\Command;
use App\Enums\LogBehavior;
use DB;

class DeleteKeyByDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log-behavior:delete-key-by-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete key by date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $while = true;
        $prevDate = date('Y-m-d', strtotime('-1 day'));
        $selectDate = $prevDate;
        while ($while) {
            if (strtotime($selectDate) == strtotime('2023-10-19')) {
                break;
            }

            DB::connection('mongodb')
                ->table('log_behavior_cache')
                ->where('key', LogBehavior::CACHE_DATE . '_' . $selectDate)
                ->delete();

            dump('Delete key by date: ' . $selectDate);

            $selectDate = date('Y-m-d', strtotime('-1 day', strtotime($selectDate)));
        }
    }
}

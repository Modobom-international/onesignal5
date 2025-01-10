<?php

namespace App\Console\Commands\LogBehavior;

use Illuminate\Console\Command;
use App\Helper\Common;
use DB;

class DeleteBehaviorEmpty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log-behavior:delete-behavior-empty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete behavior empty';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $allDates = [];
        $count = 1;

        $startDate = strtotime("$lastYear-01-01");
        $endDate = strtotime("$lastYear-12-31");

        while ($startDate <= $endDate) {
            $allDates[] = date('Y-m-d', $startDate);
            $startDate = strtotime("+1 day", $startDate);
        }

        foreach ($allDates as $selectDate) {
            $dateEstimate1 = $selectDate . ' 00:00:00';
            $dateEstimate2 = $selectDate . ' 23:59:59';

            $fromQuery = Common::covertDateTimeToMongoBSONDateGMT7($dateEstimate1);
            $toQuery = Common::covertDateTimeToMongoBSONDateGMT7($dateEstimate2);

            $getLogBehavior = DB::connection('mongodb')
                ->table('log_behavior_history')
                ->whereBetween('date_install', [$fromQuery, $toQuery])
                ->get();

            dump('Get ' . count($getLogBehavior) . ' records from log_behavior_history with date ' . $selectDate);

            foreach ($getLogBehavior as $logBehavior) {
                $status = DB::connection('mongodb')
                    ->table('log_behavior_history')
                    ->where('id', $logBehavior->_id)
                    ->delete();

                dump('Delete record ' . $count . ' with status delete ' . $status);

                $count++;
            }
        }
    }
}

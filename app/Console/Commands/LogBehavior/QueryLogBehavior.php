<?php

namespace App\Console\Commands\LogBehavior;

use Illuminate\Console\Command;
use App\Helper\Common;
use DB;

class QueryLogBehavior extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log-behavior:query-log-behavior';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Query log behavior';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dateFormat = '2025-01-03';
        $dateEstimate1 = $dateFormat . ' 15:00:00';
        $dateEstimate2 = $dateFormat . ' 23:00:00';

        $fromQuery = Common::covertDateTimeToMongoBSONDateGMT7($dateEstimate1);
        $toQuery = Common::covertDateTimeToMongoBSONDateGMT7($dateEstimate2);

        $result = DB::connection('mongodb')->table('log_behavior')
            ->whereBetween('date', [$fromQuery, $toQuery])
            ->where('network', 'DiGi_50216')
            ->where('behavior', 'LIKE', '%INSTALL%')
            ->count();

        dd($result);
    }
}

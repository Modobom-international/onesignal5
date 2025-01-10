<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helper\Common;
use Illuminate\Support\Facades\DB;

class QueryForDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'binhchay:query-for-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Query for database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $now = '2024-08-12';
        // $dateEstimate1 = $now . ' 00:00:00';
        // $dateEstimate2 = $now . ' 09:00:00';

        // $fromQuery = Common::covertDateTimeToMongoBSONDateGMT7($dateEstimate1);
        // $toQuery = Common::covertDateTimeToMongoBSONDateGMT7($dateEstimate2);

        // $getDB = DB::connection('mongodb')
        //     ->table('log_behavior')
        //     ->where('behavior', 'LIKE', '%SAI_COUNTRY%')
        //     ->whereBetween('date', [$fromQuery, $toQuery])
        //     ->count();

        // dump($getDB);


        $getCheckInListApp = DB::connection('mongodb')
            ->table('app_install')
            ->get();

        foreach ($getCheckInListApp as $record) {
            $dataUpdate = [
                'app' => strtolower($record['app']),
                'country' => strtolower($record['country']),
                'platform' => strtolower($record['platform'])
            ];

            $idUpdate = (string) new \MongoDB\BSON\ObjectId($record['_id']);

            DB::connection('mongodb')
                ->table('app_install')
                ->where('_id', $idUpdate)
                ->update($dataUpdate);
        }

        dump('------------Done');
    }
}

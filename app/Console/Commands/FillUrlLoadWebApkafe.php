<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FillUrlLoadWebApkafe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load-web:fill-url-apkafe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill url load web apkafe';

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
        $query = \DB::table('url_load_web')->where('domain', 'apkafe')->where('status', 1)->limit(200)->get();

        if (count($query) > 0) {
            $dataApkafe = $query->toArray();
            $apkafeUrlNew = [];
            shuffle($dataApkafe);
            foreach ($dataApkafe as $urlRecord) {
                $apkafeUrlNew[] = $urlRecord->url;
            }
            $data = [
                'apkafe_url' => json_encode($apkafeUrlNew)
            ];

            $apkLoadWeb = \DB::table('apk_load_web')->first();
            if (empty($apkLoadWeb)) {
                \DB::table('apk_load_web')->insert($data);
            } else {
                \DB::table('apk_load_web')->where('id', $apkLoadWeb->id)->update($data);
            }

            foreach ($query as $record) {
                \DB::table('url_load_web')->where('id', $record->id)->update(['status' => false]);
            }

            dump('-------------- Filled url load web apkafe --------------');
        } else {
            $query = \DB::table('url_load_web')->whereIn('domain', 'apkafe')->get();
            if (count($query) == 0) {
                dump('-------------- Apkafe url is empty --------------');
            } else {
                $data = [
                    'status' => true
                ];
                \DB::table('url_load_web')->where('domain', 'apkafe')->update($data);

                $query = \DB::table('url_load_web')->where('domain', 'apkafe')->where('status', 1)->limit(100)->get();

                $dataApkafe = $query->toArray();
                $apkafeUrlNew = [];
                shuffle($dataApkafe);
                foreach ($dataApkafe as $urlRecord) {
                    $apkafeUrlNew[] = $urlRecord->url;
                }
                $data = [
                    'apkafe_url' => json_encode($apkafeUrlNew)
                ];

                $apkLoadWeb = \DB::table('apk_load_web')->first();
                if (empty($apkLoadWeb)) {
                    \DB::table('apk_load_web')->insert($data);
                } else {
                    \DB::table('apk_load_web')->where('id', $apkLoadWeb->id)->update($data);
                }

                $updateStatusId = [];
                foreach ($query as $record) {
                    $updateStatusId[] = $record->id;
                }

                \DB::table('url_load_web')->whereIn('id', $updateStatusId)->update(['status' => false]);

                dump('-------------- Filled url load web apkafe --------------');
            }
        }
    }
}

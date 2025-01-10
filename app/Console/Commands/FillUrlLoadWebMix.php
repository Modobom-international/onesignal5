<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FillUrlLoadWebMix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load-web:fill-url-mix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill url load web mix';

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
        $domainBetonamuryori = 'betonamuryori';
        $queryBetonamuryori = \DB::table('url_load_web')->where('domain', $domainBetonamuryori)->where('status', 1)->limit(50)->get();
        $dataUpdate = [
            'status' => true
        ];

        if (count($queryBetonamuryori) == 0) {
            dump('-------------- Betonamuryori url is empty --------------');

            \DB::table('url_load_web')->where('domain', $domainBetonamuryori)->update($dataUpdate);

            $queryBetonamuryori = \DB::table('url_load_web')->where('domain', $domainBetonamuryori)->where('status', 1)->limit(50)->get();
        }

        $arrBetonamuryori = $queryBetonamuryori->toArray();
        shuffle($arrBetonamuryori);
        $mixUrlNew = [];
        $mixIdNew = [];
        foreach ($arrBetonamuryori as $urlRecord) {
            if (count($mixUrlNew) <= 50) {
                $mixUrlNew[] = $urlRecord->url;
                $mixIdNew[] = $urlRecord->id;
            }
        }

        $data = [
            'main_url' => json_encode($mixUrlNew)
        ];

        $apkLoadWeb = \DB::table('apk_load_web')->first();
        if (empty($apkLoadWeb)) {
            \DB::table('apk_load_web')->insert($data);
        } else {
            \DB::table('apk_load_web')->where('id', $apkLoadWeb->id)->update($data);
        }

        \DB::table('url_load_web')->whereIn('id', $mixIdNew)->update(['status' => false]);

        //delete cache when update data
        $keyCacheLoadWeb = 'cache_apk_load_web';
        $resultDelete = \Cache::store('redis')->forget($keyCacheLoadWeb);
        dump('Delete cache key '.$keyCacheLoadWeb.', result: '.$resultDelete);

        dump('-------------- Filled url load web mix --------------');
    }
}

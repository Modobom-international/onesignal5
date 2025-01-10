<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FillUrlForPushSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-url-for-push-system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill url for push system';

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
        $listUlr = [];
        $listByPercent = [];
        $arrPercent = [
            'https://gametopsv.com' => 2,
            'https://letprogame.com' => 2,
            'https://tobegame.com' => 5,
            'https://gamefulls.com' => 5,
            'https://topstickmangames.com' => 5,
            'https://topboxinggames.com' => 9,
            'https://grannygames.net' => 6,
            'https://gamemuchs.com' => 6,
            'https://vnitourist.com' => 10,
            'https://vnifood.com' => 20,
            'https://betonamuryori.com' => 30,
        ];
        $files = Storage::disk('public_csv')->allFiles();
        $getListUrl = DB::table('url_push_system')->get();

        dump('Total file : ' . count($files));
        dump('Total data in DB : ' . count($getListUrl));

        foreach ($files as $file) {
            $row = 1;
            if (($handle = fopen((public_path('/csv/') . $file), "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $listUlr[] = $data[0];
                    $row++;
                }
                fclose($handle);
            }
        }

        if (count($getListUrl) > 0) {
            foreach ($getListUrl as $record) {
                $url = $record->url;
                if (in_array($url, $listUlr)) {
                    if (($key = array_search($url, $listUlr)) !== false) {
                        unset($listUlr[$key]);
                    }
                }
            }
        }

        if (count($listUlr) > 0) {
            $listInsert = [];
            foreach ($listUlr as $urlRaw) {
                $listInsert[] = ['url' => $urlRaw, 'status' => 0];
            }

            DB::table('url_push_system')->insert($listInsert);

            dump('Insert DB with ' . count($listUlr) . ' url');
        } else {
            dump('No need to insert url');
        }

        foreach ($arrPercent as $domain => $percent) {
            $getUrlPush = DB::table('url_push_system')->where('url', 'LIKE', '%' . $domain . '%')->where('status', 0)->limit($percent)->get();

            if (count($getUrlPush) != $percent) {
                foreach ($getUrlPush as $push) {
                    $listByPercent[] = $push->url;
                }
                $dataUpdate = ['status' => 0];

                DB::table('url_push_system')->where('url', 'LIKE', '%' . $domain . '%')->update($dataUpdate);

                $percentSecond = $percent - count($getUrlPush);
                $getSecondTime = DB::table('url_push_system')->where('url', 'LIKE', '%' . $domain . '%')->where('status', 0)->limit($percentSecond)->get();

                foreach ($getSecondTime as $second) {
                    $listByPercent[] = $second->url;
                }
            } else {
                foreach ($getUrlPush as $push) {
                    $listByPercent[] = $push->url;
                }
            }
        }

        foreach ($listByPercent as $urlPercent) {
            $dataUpdatePercent = ['status' => 1];
            DB::table('url_push_system')->where('url', $urlPercent)->update($dataUpdatePercent);
        }

        $getConfig = DB::table('push_systems_config_new')->where('push_count', "!=", 0)->get();

        foreach ($getConfig as $item) {
            $json_decode = json_decode($item->config_links, true);
            $json_decode['link_push_2'] = $listByPercent;
            $json_encode = json_encode($json_decode);
            $dataUpdateConfig = [
                'config_links' => $json_encode
            ];

            DB::table('push_systems_config_new')->where('id', $item->id)->update($dataUpdateConfig);
        }
    }
}

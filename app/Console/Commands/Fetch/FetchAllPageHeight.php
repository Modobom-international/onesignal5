<?php

namespace App\Console\Commands\Fetch;

use Illuminate\Console\Command;
use Spatie\Browsershot\Browsershot;
use App\Helper\Common;
use DB;

class FetchAllPageHeight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:all-page-height';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch all page with height';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $getHeatMap = DB::connection('mongodb')
            ->table('heat_map')
            ->select('path', 'domain')
            ->get();

        $groupBy = $getHeatMap->groupBy('domain');
        $listAbort = [];
        foreach ($groupBy as $domain => $record) {
            foreach ($record as $item) {
                try {
                    $url = 'https://' . $domain . $item->path;
                    if (in_array($url, $listAbort)) {
                        continue;
                    }

                    $listAbort[] = $url;
                    $height = Browsershot::url($url)
                        ->setNodeBinary('/usr/bin/node')
                        ->setNpmBinary('/usr/bin/npm')
                        ->setChromePath('/usr/bin/google-chrome')
                        ->addChromiumArguments(['no-sandbox'])
                        ->waitUntilNetworkIdle()
                        ->setDelay(5000)
                        ->evaluate('document.body.scrollHeight');

                    $getPagesHeight = DB::connection('mongodb')->table('pages_height')->where('url', $url)->first();

                    if (empty($getPagesHeight)) {
                        DB::connection('mongodb')->table('pages_height')->insert([
                            'domain' => $domain,
                            'path' => $item->path,
                            'url' => $url,
                            'height' => $height,
                            'fetched_at' => Common::covertDateTimeToMongoBSONDateGMT7(date('Y-m-d H:i:s')),
                        ]);

                        dump('Inserted height with url ' . $url);
                    } else {
                        DB::connection('mongodb')->table('pages_height')->where('url', $url)->update([
                            'height' => $height,
                            'fetched_at' => Common::covertDateTimeToMongoBSONDateGMT7(date('Y-m-d H:i:s')),
                        ]);

                        dump('Updated height with url ' . $url);
                    }
                } catch (\Exception $e) {
                    $this->error("Lỗi khi lấy chiều cao: " . $e->getMessage());
                    continue;
                }
            }
        }
    }
}

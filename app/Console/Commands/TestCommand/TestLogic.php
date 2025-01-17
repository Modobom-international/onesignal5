<?php

namespace App\Console\Commands\TestCommand;

use App\Jobs\FetchPageHeight;
use Illuminate\Console\Command;
use DB;

class TestLogic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $url;
    protected $signature = 'test:logic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->url = 'https://apkafe.com/s/';
        try {
            $getPagesHeight = DB::connection('mongodb')->table('pages_height')->where('url', $this->url)->first();

            if (empty($getPagesHeight)) {
                $height = Browsershot::url($this->url)
                    ->setNodeBinary('/usr/bin/node')
                    ->setNpmBinary('/usr/bin/npm')
                    ->setChromePath('/usr/bin/google-chrome')
                    ->addChromiumArguments(['no-sandbox'])
                    ->waitUntilNetworkIdle()
                    ->setDelay(5000)
                    ->evaluate('document.body.scrollHeight');

                DB::connection('mongodb')->table('pages_height')->insert([
                    'domain' => $this->domain,
                    'path' => $this->path,
                    'url' => $this->url,
                    'height' => $height,
                    'fetched_at' => Common::covertDateTimeToMongoBSONDateGMT7(date('Y-m-d H:i:s')),
                ]);

                dump('Inserted height with url ' . $this->url);
            }
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }
}

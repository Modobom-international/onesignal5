<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Browsershot\Browsershot;
use App\Helper\Common;
use DB;

class FetchPageHeight implements ShouldQueue
{
    use Queueable;

    protected $url;
    protected $path;
    protected $domain;

    /**
     * Create a new job instance.
     */
    public function __construct($url, $path, $domain)
    {
        $this->url = $url;
        $this->path = $path;
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
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

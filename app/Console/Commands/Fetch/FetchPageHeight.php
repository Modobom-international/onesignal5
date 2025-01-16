<?php

namespace App\Console\Commands\Fetch;

use Illuminate\Console\Command;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\DB;

class FetchPageHeight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:page-height';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch total page height by scrolling to the bottom';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $url = 'https://apkafe.com';

            $height = Browsershot::url($url)
                ->setNodeBinary('/usr/bin/node')
                ->setNpmBinary('/usr/bin/npm')
                ->setChromePath('/usr/bin/google-chrome')
                ->waitUntilNetworkIdle()
                ->setDelay(3000)
                ->evaluate('document.body.scrollHeight');

            dd($height);

            DB::connection('mongodb')->table('pages_height')->insert([
                'url' => $url,
                'height' => $height,
                'fetched_at' => now(),
            ]);
        } catch (\Exception $e) {
            $this->error("Lỗi khi lấy chiều cao: " . $e->getMessage());
        }
    }
}

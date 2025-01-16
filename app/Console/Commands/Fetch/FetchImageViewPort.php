<?php

namespace App\Console\Commands\Fetch;

use Illuminate\Console\Command;

class FetchImageViewPort extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:image-view-port';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Browsershot::url('https://example.com')
            ->clip($x, $y, $width, $height)
            ->save($pathToImage);
    }
}

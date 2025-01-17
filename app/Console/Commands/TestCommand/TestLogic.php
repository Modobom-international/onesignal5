<?php

namespace App\Console\Commands\TestCommand;

use Illuminate\Console\Command;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

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
        $this->data = [
            'url' => 'https://apkafe.com/',
            'uuid' => '6da8fe2f-70fe-42a5-b2dd-ddf35291b0ba',
            'x' => 400,
            'y' => 0,
            'width' => 435,
            'height' => 725,
            'domain' => 'apkafe.com',
            'path' => '/'
        ];

        $tempFilePath = storage_path('app/temp_screenshot.png');
        $disk = Storage::disk('browsershot');
        $file = 'browsershot_fullpage_' . $this->data['domain'] . '_' . str_replace('/', '_', $this->data['path']) . '.png';

        $result = Browsershot::url($this->data['url'])
            ->setNodeBinary('/usr/bin/node')
            ->setNpmBinary('/usr/bin/npm')
            ->setChromePath('/usr/bin/google-chrome')
            ->noSandbox()
            ->waitUntilNetworkIdle()
            ->fullPage()
            ->mobile()
            ->paperSize($this->data['width'], $this->data['height'], 'px')
            ->windowSize($this->data['width'], $this->data['height'])
            ->evaluate("window.scrollTo(0, document.body.scrollHeight);");

        Browsershot::html($result)
            ->save($tempFilePath);

        $disk->put($file, file_get_contents($tempFilePath));
        unlink($tempFilePath);
    }
}

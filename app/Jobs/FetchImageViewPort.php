<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class FetchImageViewPort implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tempFilePath = storage_path('app/temp_screenshot.png');
        $disk = Storage::disk('browsershot');
        $file = 'browsershot_viewport_' . $this->data['x'] . '_' . $this->data['y'] . '_' . $this->data['width'] . '_' . $this->data['height'] . '_' . $this->data['domain'] . '_' . str_replace('/', '_', $this->data['path']) . '.png';

        Browsershot::url($this->data['url'])
            ->setNodeBinary('/usr/bin/node')
            ->setNpmBinary('/usr/bin/npm')
            ->setChromePath('/usr/bin/google-chrome')
            ->noSandbox()
            ->clip($this->data['y'], $this->data['x'], $this->data['width'], $this->data['height'])
            ->save($tempFilePath);

        Browsershot::closeBrowser();

        $disk->put($file, file_get_contents($tempFilePath));
        unlink($tempFilePath);
    }
}

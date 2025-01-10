<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\ReportGoogleChecker;
use Illuminate\Support\Facades\Notification;

class NotifyTelegramInstallApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    private $timeQueue;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $timeQueue)
    {
        $this->data = $data;
        $this->timeQueue = $timeQueue;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $strListApp = '';
        foreach ($this->data as $app) {
            $strListApp .= "\n\r + " . $app;
        }

        $details = [
            'message' =>
            "Notification of applications not installed in the past 1 hour ( " . $this->timeQueue . " )  \n\r" . " --- List App: " . $strListApp,
        ];

        Notification::route('telegram', env('TELEGRAM_NOTIFY_INSTALL_APP'))->notify(new ReportGoogleChecker($details));
    }
}

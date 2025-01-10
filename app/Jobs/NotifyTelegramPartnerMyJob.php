<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyTelegramPartnerMyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    private $export;
    private $type;
    private $country;

    /**
     * Create a new job instance.
     *
     * @param $data
     * @param $export
     */
    public function __construct($data, $export, $type, $country = '')
    {
        $this->data = $data;
        $this->export = $export;
        $this->type = $type;
        $this->country = $country;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            /**
            if ($this->type == 'otp') {
                $details = [
                    'message' =>
                    "Notify For Partner MY \n\r" . "--- Data: " . $this->data . "\n\r \n\r --- Platform: " . $this->country . "\n\r \n\r --- URL: " . $this->export['url'] . "\n\r --- OTP: " . $this->export['pin']
                ];
            } else {
                $details = [
                    'message' =>
                    "Notify For Partner DIGI \n\r" . "--- Data URL: " . $this->data . "\n\r \n\r --- Platform: " . $this->country . "\n\r \n\r --- URL: " . $this->export['url'],
                ];
            }

            Notification::route('telegram', env('TELEGRAM_NOTIFY_FOR_PARTNER_MY_ID'))->notify(new ReportGoogleChecker($details));
             * */

            //subscribe Umobile Malaysia in job NotifyTelegramWapUrl


        } catch (\Exception $ex) {
            \Log::channel('malaysia')->error($ex);
        }
    }
}

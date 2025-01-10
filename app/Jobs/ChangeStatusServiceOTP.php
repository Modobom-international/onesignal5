<?php

namespace App\Jobs;

use App\Enums\ServiceOTP;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ChangeStatusServiceOTP implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $task_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($task_id)
    {
        $this->task_id = $task_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $getOTP = \DB::table('service_otp')->where('id', $this->task_id)->first();

        if (isset($getOTP)) {
            if ($getOTP->status == ServiceOTP::STATUS_WAITING) {
                \DB::table('service_otp')->where('id', $getOTP->id)->update(['status' => ServiceOTP::STATUS_TIME_OUT]);
            }
        }
    }
}

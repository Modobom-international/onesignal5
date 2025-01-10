<?php

namespace App\Jobs;

use App\Helper\Common;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SaveUserActivePushSystemGlobal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $token;
    private $country;
    private $params;

    /**
     * Create a new job instance.
     *
     * @param $token
     * @param $country
     */
    public function __construct($token, $country)
    {
        $this->token = $token;
        $this->country = $country;
        $this->params = [
          'token' => $token,
          'country' => $country,
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $resultInsert = \DB::table('push_system_global_user_active')->insert([
            'token' => $this->token,
            'country' => $this->country,
            'activated_at' => Common::getCurrentVNTime(),
            'activated_date' => Common::getCurrentVNTime('Y-m-d'),
        ]);

        dump('Inserted user active push system. params: '.json_encode($this->params).', result: '.$resultInsert);

    }
}

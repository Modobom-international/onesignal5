<?php


namespace App\Helper;


use App\Notifications\AmazonChecker;
use App\Notifications\SupervisorChecker;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Supervisor
{
    const API_TIME_OUT = 30; //15 seconds

    const COUNTRY_GTOSVN = 'GTOSVN';
    const COUNTRY_MWM = 'MWM';
    const COUNTRY_SHIGTM = 'SHIGTM';
    const COUNTRY_PHOENIXMANZ = 'PHOENIXMANZ';
    const COUNTRY_CYBERNETWORK = 'CYBERNETWORK';
    const COUNTRY_POWOD = 'POWOD';
    const COUNTRY_MODOBOM = 'MODOBOM';
    const COUNTRY_SHINDAKIBA = 'SHINDAKIBA';
    const COUNTRY_LOCAL = 'LOCAL';

    const COUNTRY_MAP = [
        self::COUNTRY_GTOSVN => '',
        self::COUNTRY_MWM => '',
        self::COUNTRY_SHIGTM => '',
        self::COUNTRY_PHOENIXMANZ => '',
        self::COUNTRY_CYBERNETWORK => '',
        self::COUNTRY_POWOD => '',
        self::COUNTRY_MODOBOM => '',
        self::COUNTRY_SHINDAKIBA => '',
        self::COUNTRY_LOCAL => [
            'auth' => [
                'user' => 'admin',
                'pass' => 'GEivjuII47mysz',
            ],
            'url' => 'http://118.70.119.46:9001/',
        ],

    ];

    public static function checkSupervisorStatusByCLI()
    {
        $process = Process::fromShellCommandline("supervisorctl status | awk '{print $1, $2}'");

        $stoppedProcess = [];
        try {
            $process->run();

            dump($process->getOutput());

            $rows = array_filter(explode("\n", $process->getOutput()), 'strlen');

//            $rows = [
//                "horizon_croatia_middle:horizon_croatia_middle_00 STOPPED",
//                "horizon_croatia_middle_new RUNNING",
//                "horizon_czech_middle:horizon_czech_middle_00 RUNNING",
//
//            ];

            foreach ($rows as $row) {
                $parts = explode(' ', $row);

                $statusRunning = 'RUNNING';
                $statusNeedStart = [
                    'STOPPED',
                ];
                $statusNeedNotify = [
                    'STOPPED',
                    'FATAL',
                ];

                $currentStatus = strtoupper($parts[1]);
                if ($currentStatus != trim(strtoupper($statusRunning))) {

                    if (in_array($currentStatus, $statusNeedStart)) {
                        $processStart = Process::fromShellCommandline(sprintf("supervisorctl start %s", $parts[0]));
                        $processStart->run();
                    }

                    $stoppedProcess[] = $parts[0];

                    //notify to telegram
                    $details = [
                        'message' => sprintf("*Supervisor process STOPPED*, please check! \n(system trying to start again...)\n\n- Process name: \n*%s*\n\n- IP: %s", $parts[0], env('VPS_IP')),
                    ];

                    \Notification::route('telegram', env('TELEGRAM_CHECK_SERVICE_BOT_CHAT_ID'))->notify(new SupervisorChecker($details));
                }
            }


        } catch (\Exception $e) {
            dump($e->getMessage());

        }

        return $stoppedProcess;
    }

    public static function checkSupervisorStatusByWeb($country)
    {
        $country = strtoupper($country);
        if (empty(self::COUNTRY_MAP[$country]['url'])) {
            throw new \InvalidArgumentException('Invalid country/url');
        }

        $url = self::COUNTRY_MAP[$country]['url'];

        if (!empty(self::COUNTRY_MAP[$country]['auth']['user'])) {
            $client = new \GuzzleHttp\Client([
                'timeout' => self::API_TIME_OUT,
                'auth' => [
                    self::COUNTRY_MAP[$country]['auth']['user'],
                    self::COUNTRY_MAP[$country]['auth']['pass'],
                ],
            ]);

        } else {

            $client = new \GuzzleHttp\Client([
                'timeout' => self::API_TIME_OUT,
            ]);

        }


        $response = $client->request('GET', $url);

        $contents = $response->getBody()->getContents();
        dd($contents);

    }


}

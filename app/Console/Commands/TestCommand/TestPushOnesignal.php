<?php

namespace App\Console\Commands;

use App\Helper\Onesignal;
use Illuminate\Console\Command;

class TestPushOnesignal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-push-onesignal {playerId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $playerId = strtolower($this->argument('playerId'));
        $country = 'thailand';
        $dataType = 'web';

        $file = storage_path(sprintf('onesignal/data/%s/%s.txt', $country, $dataType));
        if (!is_file($file)) {
            $this->error('Country or data type is invalid!');
            exit(0);
        }

        $messages = file_get_contents($file);
        $tmp = json_decode($messages, true);

        shuffle($tmp);
        $message = $tmp[array_rand($tmp)];
        if (empty($message)) {
            $this->info('Message is null, nothing to do!');
            exit;
        }

        $response = Onesignal::sendNotificationByIds($country, json_encode($message), $playerId);

        dump($message);
        dump($response);


    }
}

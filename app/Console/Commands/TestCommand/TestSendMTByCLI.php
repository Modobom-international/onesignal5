<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestSendMTByCLI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-send-mt-by-cli {country} {keyword} {shortcode}';

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
        $country = strtoupper(trim($this->argument('country')));
        $kw = trim($this->argument('keyword'));
        $shortcode = trim($this->argument('shortcode'));

        $keyword = strtoupper($kw.'_'.$shortcode);

        $mapping = [
            'THAILAND' => [
                'SD_4541427' => [
                    'path' => '/home/gtosvn/apisdgt08HP/apisd.gtosvn.com/public_html',
                ],
            ]

        ];


    }
}

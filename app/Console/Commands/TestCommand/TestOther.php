<?php

namespace App\Console\Commands\TestCommand;

use App\Services\CloudFlareService;
use Illuminate\Console\Command;
use App\Services\GoDaddyService;

class TestOther extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'test:other';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test other command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = 'vutuan.modobom@gmail.com';
        $domain = 'doomapk.com';
        $cloudFlareService = new CloudFlareService();

        $result = $cloudFlareService->deleteDomain(
            $domain
        );

        dd($result);
    }
}

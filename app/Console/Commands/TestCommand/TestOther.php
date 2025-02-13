<?php

namespace App\Console\Commands\TestCommand;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class TestOther extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $url;
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
        $apiUrl = config('services.cloudflare.api_url');
        $apiToken = config('services.cloudflare.api_token_edit_zone');
        $apiTokenDNS = config('services.cloudflare.api_token_edit_zone_dns');
        $accountId = config('services.cloudflare.account_id');
        $domain = 'gamesnood.com';
        $ip = '139.162.44.151';

        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $apiTokenDNS,
                'Content-Type' => 'application/json',
            ],
        ]);

        $zoneId = $this->getZoneId($domain);
        if (!$zoneId) {
            dd('Không tìm thấy Zone ID');
        }

        $body = [
            'type' => 'A',
            'name' => $domain,
            'content' => $ip,
            'ttl' => 1,
            'proxied' => true
        ];

        $response = $client->post($apiUrl . "/zones/{$zoneId}/dns_records", [
            'json' => $body
        ]);

        dd(json_decode($response->getBody(), true));
    }
}

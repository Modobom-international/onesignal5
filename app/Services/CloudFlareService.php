<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CloudFlareService
{
    protected $client;
    protected $apiToken;
    protected $apiUrl;
    protected $accountId;

    public function __construct()
    {
        $this->apiUrl = config('services.cloudflare.api_url');
        $this->apiToken = config('services.cloudflare.api_token');
        $this->accountId = config('services.cloudflare.account_id');

        $this->client = new Client([
            'base_uri' => $this->apiUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function getZoneId($domain)
    {
        $response = $this->client->get('/zones', [
            'name' => $domain,
        ]);

        return optional($response->json()['result'][0])['id'] ?? null;
    }

    public function updateDnsARecord($domain, $ip)
    {
        $zoneId = $this->getZoneId($domain);
        if (!$zoneId) {
            return ['error' => 'Không tìm thấy Zone ID'];
        }

        $response = $this->client->get("/zones/{$zoneId}/dns_records", [
            'type' => 'A',
            'name' => $domain
        ]);

        $records = $response->json()['result'];
        $body = [
            'type' => 'A',
            'name' => $domain,
            'content' => $ip,
            'ttl' => 1,
            'proxied' => true
        ];

        if (!empty($records)) {
            $response = $this->client->put("/zones/{$zoneId}/dns_records/{$recordId}", $body);

            return json_decode($response->getBody(), true);
        } else {
            $response = $this->client->post("/zones/{$zoneId}/dns_records", $body);

            return json_decode($response->getBody(), true);
        }
    }

    public function addDomainToCloudflare($domain)
    {
        $body = [
            'name' => $domain,
            'account' => ['id' => $this->accountId],
            'jump_start' => true
        ];

        try {
            $response = $this->client->post('/zones', ['json' => $body]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    private function handleException(RequestException $e)
    {
        if ($e->hasResponse()) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }

        return ['error' => 'Something went wrong'];
    }
}

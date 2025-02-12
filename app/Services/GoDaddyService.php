<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GoDaddyService
{
    protected $client;
    protected $apiKey;
    protected $apiSecret;
    protected $apiUrl;

    public function __construct()
    {
        $user = Auth::user();
        $email = $user ? $user->email : 'default@email.com';

        if ($email == 'vutuan.modobom') {
            $this->apiKey = config('services.godaddy_tuan.api_key');
            $this->apiSecret = config('services.godaddy_tuan.api_secret');
            $this->apiUrl = config('services.godaddy_tuan.api_url');
        } else if ($email == 'tranlinh.modobom') {
            $this->apiKey = config('services.godaddy_linh.api_key');
            $this->apiSecret = config('services.godaddy_linh.api_secret');
            $this->apiUrl = config('services.godaddy_linh.api_url');
        } else {
            $this->apiKey = config('services.godaddy.api_key');
            $this->apiSecret = config('services.godaddy.api_secret');
            $this->apiUrl = config('services.godaddy.api_url');
        }

        $this->client = new Client([
            'base_uri' => $this->apiUrl,
            'headers' => [
                'Authorization' => 'sso-key ' . $this->apiKey . ':' . $this->apiSecret,
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function getDomains()
    {
        try {
            $response = $this->client->get('/v1/domains');
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    public function getDomainDetails($domain)
    {
        try {
            $response = $this->client->get("/v1/domains/{$domain}");
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    public function updateNameservers($domain, $nameservers)
    {
        $body = [
            "nameservers" => $nameservers
        ];

        try {
            $response = $this->client->put("/v1/domains/{$domain}/nameservers", [
                'json' => $body
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    public function getNameservers($domain)
    {
        try {
            $response = $this->client->get("/v1/domains/{$domain}/records/NS");

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

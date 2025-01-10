<?php


namespace App\Helper;


use Carbon\Carbon;

class DomainExpiresChecker
{
    const GODADDY_ACC_INFO = [
        'vylizh1' => [
            'apiKey' => 'e4hbFoWzuUme_SgWRVT68RiuoxQb55YGx5z',
            'apiSecret' => 'LYkNKZDDy3UjrUMs4jDwJx',
        ],
        'vylizh2@gmail.com' => [
            'apiKey' => 'e4hbJHhaMP2r_XPLvG4QdWxDV8BbneL1w6E',
            'apiSecret' => '3RZqgpPpfsbP1gL8YhSEPq',
        ],

        'vylizh3@gmail.com' => [
            'apiKey' => 'e4hbJo39v5jU_CD1gjg8TU76bkqCnaNm6vV',
            'apiSecret' => 'Chm1zswtTfa6kr4Tex88Y5',
        ],

        'vylizh4@gmail.com' => [
            'apiKey' => 'e4hbJo9U51JE_K2HcJJsncsnHaDL3kaxL8d',
            'apiSecret' => 'T6g56EJUjkrswfT4LsXJDt',
        ],

        '209944368' => [
            'apiKey' => 'e42s2gyRiMw5_V6GvS4yKKi93sjSRnDGRc4',
            'apiSecret' => 'D2u3vf2Eb9MwZrLFiT7KE8',
        ],

        '181812460' => [
            'apiKey' => 'dLYectbf9cKH_71zHAuMfTs8tGu1gLHeb1B',
            'apiSecret' => '3ttvXfo6uQpJXHqwer9de4',
        ],

        'vylinh89' => [
            'apiKey' => 'dLiTrMbsGSis_F5ruRHFVuaPh8cnt2CuDVE',
            'apiSecret' => '4BpU2GHryboZB9N9h1MPYF',
        ],

        'mdbtranlinh' => [
            'apiKey' => 'h1UcHUrPRc8t_CwmUkwRQ9uWiGV6fH5br9D',
            'apiSecret' => 'Gp38Ja9r3xEgTSNai3wxx9',
        ],

        'TongThaoVy' => [
            'apiKey' => 'h1UcHUrQsuZ8_YCjwJxjWh2fYHK6ts3crQT',
            'apiSecret' => 'Umvsqe8c7FsULzJtBx7BEz',
        ],

        'vutuan.modobom' => [
            'apiKey' => 'h1UcHUrPRGRd_334hWC8reQqUZx9cr9dcRc',
            'apiSecret' => 'WJbtKvqnJswLfwTYDLxx3N',
        ],

    ];

    public static function getDomainsInfo($accGodaddy)
    {
        $keyInfo = self::GODADDY_ACC_INFO[$accGodaddy] ?? null;
        if (empty($keyInfo)) {
            return [];
        }

        $apiKey = $keyInfo['apiKey'];
        $apiSecret = $keyInfo['apiSecret'];


// Set the isProduction flag to false to use the test environment
        $isProduction = true;

// Create an instance of GoDaddyAPI for the test environment
        $goDaddyAPI = new \GoDaddyAPI\GoDaddyAPI($apiKey, $apiSecret, $isProduction);

// Access various API endpoints using the provided methods
        $domainsRequest = $goDaddyAPI->domains();

//        $abuseRequest = $goDaddyAPI->abuse();
//        $aftermarketRequest = $goDaddyAPI->aftermarket();
//        $agreementsRequest = $goDaddyAPI->agreements();
//        $certificatesRequest = $goDaddyAPI->certificates();
//        $countriesRequest = $goDaddyAPI->countries();
//        $ordersRequest = $goDaddyAPI->orders();
//        $parkingRequest = $goDaddyAPI->parking();
//        $shoppersRequest = $goDaddyAPI->shoppers();
//        $subscriptionsRequest = $goDaddyAPI->subscriptions();

        $statuses = [
            'ACTIVE',
            //'CANCELLED_REDEEMABLE',
        ];

        $domains = $domainsRequest->listDomains(null, $statuses, [], 1000)->getData();

        //dd($domains);

        ///
        /// array:17 [
        //    "createdAt" => "2024-01-17T22:22:06.000Z"
        //    "domain" => "kifoapk.com"
        //    "domainId" => 414672972
        //    "expirationProtected" => false
        //    "expires" => "2025-01-17T22:22:06.000Z"
        //    "exposeWhois" => false
        //    "holdRegistrar" => false
        //    "locked" => true
        //    "nameServers" => null
        //    "privacy" => true
        //    "registrarCreatedAt" => "2024-01-17T19:37:56.260Z"
        //    "renewAuto" => true
        //    "renewDeadline" => "2025-03-03T20:22:05.000Z"
        //    "renewable" => true
        //    "status" => "ACTIVE"
        //    "transferAwayEligibleAt" => "2024-03-17T22:22:06.000Z"
        //    "transferProtected" => false
        //  ]

        $data = [];
        foreach ($domains as $domain) {
            $tmp = $domain;
            $tmp['createdDate'] = substr($domain['createdAt'], 0, 10);
            $tmp['expiredDate'] = substr($domain['expires'], 0, 10);

            $tmp['remainingDays'] = self::remainingDays($domain['expires']);

            $data[] = $tmp;
        }

        return $data;
    }

    public static function remainingDays($endDate)
    {
        $endDate = trim($endDate);
        $end = Carbon::parse($endDate); //$expiresDate = '2024-02-27T22:15:23.000Z';
        $now = Carbon::now();
        if (strlen($endDate) == 10) {
            $now = Carbon::parse(Carbon::now()->format('Y-m-d'));
        }

        $diff = $now->diffInDays($end);

        if ($now->gt($end)) {
            $diff = '-'.$diff;
        }

        return $diff;
    }

    public static function getDomainsIdOfAccount($account)
    {
        return \DB::table('godaddy_domains')->where('account', $account)->pluck('domain_id')->toArray();
    }

}



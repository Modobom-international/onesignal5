<?php


namespace App\Helper;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

class ReportSubs
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const API_TIME_OUT = 60; //15 seconds

    public static function getTotalSubsByTelco($telcoInfo, $urlReportTelco)
    {

        //[
        //                'id' => 1,
        //                'name' => 'DTAC',
        //            ],
        //]

        $telcoId = $telcoInfo['id'];
        $telcoName = $telcoInfo['name'];

        $res = ReportSubs::callUrl($urlReportTelco);

        $arr = json_decode($res, true);
        $data = $arr['data']['mo dk']['telco'][$telcoName] ?? [];

        $subs = array_sum($data);

        return [
            'telco_id' => $telcoId,
            'telco_name' => $telcoName,
            'subs' => $subs,
        ];

    }

    public static function callUrl($url, $params = [], $method = self::METHOD_GET)
    {

        $client = new Client([
            // Base URI is used with relative requests
            //'base_uri' => 'http://httpbin.org',
            // You can set any number of default request options.
            'timeout'  => self::API_TIME_OUT,
        ]);

        try {
            $response = $client->get($url);

            return $response->getBody()->getContents();

        } catch (GuzzleException $e) {

        }

        return null;

    }

}

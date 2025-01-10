<?php


namespace App\Helper;


use Berkayk\OneSignal\OneSignalClient;

class Onesignal
{
    const KEY_APP_ID = 'ONESIGNAL_APP_ID';
    const KEY_REST_API_KEY = 'ONESIGNAL_REST_API_KEY';
    const KEY_USER_AUTH_KEY = 'ONESIGNAL_USER_AUTH_KEY';

    const COUNTRY_THAILAND = 'thailand';
    const COUNTRY_EU = 'eu';

    const VERSION_1 = 'v1';
    const VERSION_2 = 'v2';
    const VERSION_3 = 'v3';

    const PUSH_TIME_DIFF_MINUTES = [
        'apkafe' => 0,
        'vni' => 2 * 60,
        'ryori' => 4 * 60,
        'custom' => 0,
        'html5' => 0,
    ];

    const VERSIONS_SUPPORTED = [self::VERSION_1, self::VERSION_2, self::VERSION_3];

    const CREDENTIALS = [
        self::VERSION_1 => [
            self::COUNTRY_THAILAND => [
                self::KEY_APP_ID => '1fd8b10d-be52-4c4d-b53b-dbfaf9042918',
                self::KEY_REST_API_KEY => 'ZTA2ODQ2ZjUtNTEwNS00YWEzLWJkZTAtOTA1MWZiYzVhYjBl',
                self::KEY_USER_AUTH_KEY => 'OGNmMGFlNzctOTVkYi00NjViLTkyNjgtZTFlOTVmMjU3OTVl',
            ],
            self::COUNTRY_EU => [
                self::KEY_APP_ID => '1dab9629-391f-47f3-9c76-e13dae0fee93',
                self::KEY_REST_API_KEY => 'M2I0YmRlZDYtYWM3OC00NzM2LTlkN2ItMjMzYmVlNGY1ZDkz',
                self::KEY_USER_AUTH_KEY => 'OGNmMGFlNzctOTVkYi00NjViLTkyNjgtZTFlOTVmMjU3OTVl',
            ],

        ],

        self::VERSION_2 => [
            self::COUNTRY_THAILAND => [
                self::KEY_APP_ID => '507ecf6f-83bd-42d5-a161-a2e0bc84ea97',
                self::KEY_REST_API_KEY => 'MWQxYzcwZWQtMDc4Mi00ODI5LWFmOGItZTkyMDcyNzljZjll',
                self::KEY_USER_AUTH_KEY => 'OGNmMGFlNzctOTVkYi00NjViLTkyNjgtZTFlOTVmMjU3OTVl',
            ],

        ],

        self::VERSION_3 => [
            self::COUNTRY_THAILAND => [
                self::KEY_APP_ID => 'e5d29922-d6e4-4411-a4d3-73b322bde7a9',
                self::KEY_REST_API_KEY => 'MTk5MDc3NDMtY2FlNy00M2NkLWJlYjMtNjZiZjc2ZTQ5NzI4',
                self::KEY_USER_AUTH_KEY => 'OGNmMGFlNzctOTVkYi00NjViLTkyNjgtZTFlOTVmMjU3OTVl',
            ],

        ],


    ];

    public static function getCredentialsByCountry($country, $version = self::VERSION_1)
    {
        $country = strtolower(trim($country));

        return !empty(self::CREDENTIALS[$version][$country]) ? self::CREDENTIALS[$version][$country] : null;
    }

    public static function sendNotificationToSegment($country, $message, $segment, $version = Onesignal::VERSION_1, $url = null, $data = null, $buttons = null, $schedule = null, $headings = null, $subtitle = null)
    {
        $credentials = self::getCredentialsByCountry($country, $version);
        if (empty($credentials)) {
            return false;
        }

        $appId = $credentials[self::KEY_APP_ID];
        $restApiKey = $credentials[self::KEY_REST_API_KEY];
        $userAuthKey = $credentials[self::KEY_USER_AUTH_KEY];

        $client = new OneSignalClient($appId, $restApiKey, $userAuthKey);

        $contents = [
            "en" => $message,
        ];

        $params = [
            'app_id' => $appId,
            'contents' => $contents,
            'included_segments' => [$segment],
            'headings' => $contents,
        ];

        if (isset($url)) {
            $params['url'] = $url;
        }

        if (isset($data)) {
            $params['data'] = $data;
        }

        if (isset($buttons)) {
            $params['buttons'] = $buttons;
        }

        if (isset($schedule)) {
            $params['send_after'] = $schedule;
        }

        if (isset($headings)) {
            $params['headings'] = [
                "en" => $headings,
            ];
        }

        if (isset($subtitle)) {
            $params['subtitle'] = [
                "en" => $subtitle,
            ];
        }

        try {
            $response = $client->sendNotificationCustom($params);

            if (!empty($response)) {
                return json_decode($response->getBody()->getContents(), true);
            }

            return null;
        } catch (\Exception $ex) {
            //todo: save log
            dump($ex->getMessage());

            return null;
        }
    }

    public static function sendNotificationByIds($country, $message, $userIds, $version = self::VERSION_1, $url = null, $data = null, $buttons = null, $schedule = null, $headings = null, $subtitle = null)
    {
        $credentials = self::getCredentialsByCountry($country, $version);
        if (empty($credentials)) {
            return false;
        }

        $appId = $credentials[self::KEY_APP_ID];
        $restApiKey = $credentials[self::KEY_REST_API_KEY];
        $userAuthKey = $credentials[self::KEY_USER_AUTH_KEY];

        $client = new OneSignalClient($appId, $restApiKey, $userAuthKey);

        $contents = [
            "en" => $message,
        ];

        $params = [
            'title' => [
                'en' => 'Title',
            ],
            'app_id' => $appId,
            'contents' => $contents,
            'include_player_ids' => is_array($userIds) ? $userIds : [$userIds],
            'headings' => $contents,
        ];

        if (isset($url)) {
            $params['url'] = $url;
        }

        if (isset($data)) {
            $params['data'] = $data;
        }

        if (isset($buttons)) {
            $params['buttons'] = $buttons;
        }

        if (isset($schedule)) {
            $params['send_after'] = $schedule;
        }

        if (isset($headings)) {
            $params['headings'] = [
                "en" => $headings,
            ];
        }

        if (isset($subtitle)) {
            $params['subtitle'] = [
                "en" => $subtitle,
            ];
        }

        try {
            $response = $client->sendNotificationCustom($params);

            if (!empty($response)) {
                return json_decode($response->getBody()->getContents(), true);
            }

            return null;
        } catch (\Exception $ex) {
            //todo: save log
            dump($ex->getMessage());
            \Log::channel('daily')->error('[Push onesignal failed] '.$ex->getMessage());

            return null;
        }

    }

    public static function detectOTPInBody($body)
    {
        $body = strtolower($body);

        //Google->G-602944 คือรหัสยืนยัน Google ของคุณ
        //Google->Your Messenger verification code is G-939353

        if (strpos($body, 'google') !== false || strpos($body, 'g-') !== false) {
            $parts = explode('g-', $body);

            if (count($parts) === 2) {
                $tmp = $parts[1];
                $parts2 = explode(' ', $tmp);

                $otp = 'G-'.$parts2[0];
                if (strlen($parts2[0]) === 6) { //google
                    return [
                        'otp' => $otp,
                        'otp_real' => $parts2[0],
                        'raw_data' => $body,
                    ];

                }
            }

        }

        return [
            'otp' => null,
            'otp_real' => null,
            'raw_data' => $body,
        ];

    }

    public static function detectPhoneAndPlayerInBody($body)
    {
        ///+66933417626->hi:334ec285-ada5-4941-876e-695c7192f59e
        ///
        $delimiter = '->hi:';

        $parts = explode($delimiter, $body);
        $phone = null;
        $playerId = null;

        if (count($parts) === 2) {
            $phone = $parts[0];
            $playerId = $parts[1];
        }

        return [
            'phone' => $phone,
            'player_id' => $playerId,
        ];

    }

    public static function savePlayerAndPhone($phone, $playerId)
    {
        if (!empty($phone) && !empty($playerId)) {
            $check = \DB::table('players_phones')->where('phone', $phone)->first();

            if (empty($check)) {
                //insert
                \DB::table('players_phones')->insert([
                    'phone' => $phone,
                    'player_id' => $playerId,
                    'created_at' => Common::getCurrentVNTime(),
                    'updated_at' => Common::getCurrentVNTime(),
                ]);

            } else {
                //update
                \DB::table('players_phones')->where('phone', $phone)->update([
                    'player_id' => $playerId,
                    'updated_at' => Common::getCurrentVNTime(),
                ]);
            }


        }

    }

    public static function saveOTP($phone, $playerId, $otp, $rawData = null)
    {
        //phone
        //player_id
        //otp
        //raw_data
        //created_at

        if (!empty($phone) && !empty($playerId) && !empty($otp)) {
            \DB::table('sms_otp')->insert([
                'phone' => $phone,
                'player_id' => $playerId,
                'otp' => $otp,
                'raw_data' => $rawData,
                'created_at' => Common::getCurrentVNTime(),
            ]);
        }

    }

    public static function getPhoneByPlayerId($playerId)
    {
        $row = \DB::table('players_phones')->where('player_id', $playerId)->first();

        return !empty($row) ? $row->phone : null;
    }

    /**
     * Generate Onesignal message from list link in file
     *
     * @param $linkType
     * @param null $packageNumber
     * @return array
     */
    public static function generateOnesignalMessage($linkType, $version, $packageNumber = null)
    {
        $linkType = strtolower($linkType);
        $file = storage_path('onesignal/source/link-type/'.$linkType.'.txt');
        if (!is_file($file)) {
            return [];
        }

        $links = Common::file2Array($file);
        $message = null;
        if (!is_null($links)) {
            if (is_null($packageNumber)) {
                shuffle($links);
                $link = $links[array_rand($links)];

            } else {
                //todo: get current link index from redis
                $currentLinkIndex = PushOnesignalNewFlow::getPushCurrentLinkIndex($version, $linkType, $packageNumber);

                $nextIndex = (intval($currentLinkIndex) + 1);
                if (empty($links[$nextIndex])) {
                    $nextIndex = 0;
                }

                $link = $links[$nextIndex];

                //todo: save $nextIndex to redis with key: html5_current_link_index
                PushOnesignalNewFlow::setPushCurrentLinkIndex($version, $linkType, $packageNumber, $nextIndex);
            }

            ///{
            //    "type": "search",
            //    "keysearch": "gta5 apkafe.com",
            //    "site": "https://apkafe.com/product/gta-5-grand-theft-auto-v/"
            //  }

            $linkInfo = parse_url($link);

            $message = [
                'type' => 'search',
                'keysearch' => $linkInfo['host'],
                'site' => $link,
            ];

            $message['title']['en'] = 'Title';

            return $message;
        }

        return null;

    }

}

<?php


namespace App\Helper;

use Illuminate\Support\Facades\Redis;

class PushSubsAgain
{
    const KW_MK = 'MK';
    const KW_F2U = 'F2U';

    const TELCO_DTAC = 'DTAC';
    const TELCO_AIS = 'AIS';

    const LIMIT_PUSH_SUBS = 200;

    const KEY_CACHE_PUSH_PREFIX = 'push_subs_again_index_';
    const PROVIDERS = [
        self::KW_MK,
        self::KW_F2U,
    ];

    const KEYWORDS_PUSH = [

        self::KW_MK => [
            self::TELCO_DTAC => [
                //DTAC
                //EMAT_4541572
                //GO_4541370
                //IVF_4541293
                //IVG_4541293
                //RSTH_4541544
                //THRS_4541544

                [
                    'keyword' => 'EMAT',
                    'shortcode' => '4541572',
                ],
                [
                    'keyword' => 'GO',
                    'shortcode' => '4541370',
                ],
                [
                    'keyword' => 'IVF',
                    'shortcode' => '4541293',
                ],
                [
                    'keyword' => 'IVG',
                    'shortcode' => '4541293',
                ],
                [
                    'keyword' => 'RSTH',
                    'shortcode' => '4541544',
                ],
                [
                    'keyword' => 'THRS',
                    'shortcode' => '4541544',
                ],


            ],
            self::TELCO_AIS => [
                ///AIS
                //IVF_4541293
                //WICAT_4541763
                //NARA_4541352
                //GAMES_4541545
                //TCL_4541571
                //DSC_4541770
                [
                    'keyword' => 'IVF',
                    'shortcode' => '4541293',
                ],
                [
                    'keyword' => 'WICAT',
                    'shortcode' => '4541763',
                ],
                [
                    'keyword' => 'NARA',
                    'shortcode' => '4541352',
                ],
                [
                    'keyword' => 'GAMES',
                    'shortcode' => '4541545',
                ],
                [
                    'keyword' => 'TCL',
                    'shortcode' => '4541571',
                ],
                [
                    'keyword' => 'DSC',
                    'shortcode' => '4541770',
                ],

            ],
        ],

        self::KW_F2U => [
            self::TELCO_DTAC => [
                ///DTAC
                //F1_4761619
                //J1_4761469
                //R1_4761602
                //A1_4761590
                //R1_4761602
                //J1_4761469
                [
                    'keyword' => 'X1',
                    'shortcode' => '4761608',
                ],
                [
                    'keyword' => 'L1',
                    'shortcode' => '4761625',
                ],
                [
                    'keyword' => 'M1',
                    'shortcode' => '4761626',
                ],
                [
                    'keyword' => 'Z1',
                    'shortcode' => '4761643',
                ],
                [
                    'keyword' => 'F1',
                    'shortcode' => '4761619',
                ],
                [
                    'keyword' => 'J1',
                    'shortcode' => '4761469',
                ],
                [
                    'keyword' => 'R1',
                    'shortcode' => '4761602',
                ],
                [
                    'keyword' => 'A1',
                    'shortcode' => '4761590',
                ],
                [
                    'keyword' => 'R1',
                    'shortcode' => '4761602',
                ],

            ],
            self::TELCO_AIS => [
                /// AIS
                //G1_4761620
                //Z1_4761613
                //T1_4761604
                //Q1_4761601
                //M1_4761597
                [
                    'keyword' => 'X1',
                    'shortcode' => '4761608',
                ],
                [
                    'keyword' => 'L1',
                    'shortcode' => '4761625',
                ],
                [
                    'keyword' => 'M1',
                    'shortcode' => '4761626',
                ],
                [
                    'keyword' => 'Z1',
                    'shortcode' => '4761643',
                ],
                [
                    'keyword' => 'G1',
                    'shortcode' => '4761620',
                ],
                [
                    'keyword' => 'Z1',
                    'shortcode' => '4761613',
                ],
                [
                    'keyword' => 'T1',
                    'shortcode' => '4761604',
                ],
                [
                    'keyword' => 'Q1',
                    'shortcode' => '4761601',
                ],
                [
                    'keyword' => 'M1',
                    'shortcode' => '4761597',
                ],

            ],
        ],

    ];


    public static function pushSubsAgain($country = 'thailand', $limit = self::LIMIT_PUSH_SUBS, $version = Onesignal::VERSION_2)
    {
        $timeDiff = 6 * 60; //6 hours

        $playersId = \DB::table('onesignal_push_subs_again')
            ->whereRaw('(ROUND(TIMESTAMPDIFF(minute, created_at, now())) >= ?)', [$timeDiff]) //only get records diff created_at & now = 6 hours
            ->limit($limit)
            ->pluck('player_id')->toArray();

        if (count($playersId) === 0) {
            dump('[Push subs again] Nothing to do!');

            return false;
        }

        $kwMKDTAC = self::pickKwMK(self::TELCO_DTAC);
        $kwMKAIS = self::pickKwMK(self::TELCO_AIS);

        //mk
        $msgMK = [
            'type' => 'sms',
            'dtac' => [
                $kwMKDTAC,
            ],
            'ais' => [
                $kwMKAIS,
            ],
        ];

        $responseMK = Onesignal::sendNotificationByIds($country, json_encode($msgMK), $playersId, $version);
        dump('Pushed onesignal subs again - MK, count: ' . count($playersId));
        dump($responseMK);
        dump('DTAC - MK');
        dump($kwMKDTAC);
        dump('AIS - MK');
        dump($kwMKDTAC);

        //remove invalid players id
        ///All included players are not subscribed

        //save history
        $recordsMK = [];
        $recordsF2U = [];

        foreach ($playersId as $playerId) {
            $recordsMK[] = [
                'player_id' => $playerId,
                'country' => $country,
                'provider' => self::KW_MK,
                'kw_dtac' => json_encode($kwMKDTAC),
                'kw_ais' => json_encode($kwMKAIS),
                'created_at' => Common::getCurrentVNTime(),
            ];
        }

        \DB::transaction(function () use ($playersId, $recordsMK) {
            $resultMK = \DB::table('onesignal_push_subs_again_history')->insert($recordsMK);

            //delete players id
            $resultDelete = \DB::table('onesignal_push_subs_again')->whereIn('player_id', $playersId)->delete();

            dump('- Inserted history MK: result ' . $resultMK);
            dump('=> Deleted players id: result ' . $resultDelete);
        });

        dump('Done!');
    }


    public static function getCurrentKw($provider, $telco)
    {
        if (empty(self::KEYWORDS_PUSH[strtoupper(trim($provider))][strtoupper(trim($telco))])) {
            return null;
        }

        $provider = strtolower($provider);
        $telco = strtolower($telco);

        $key = self::getKeyRedisKwIndex($provider, $telco);
        $index = Redis::get($key);
        if (empty($index)) {
            $index = 0;
        }

        if (empty(self::KEYWORDS_PUSH[strtoupper(trim($provider))][strtoupper(trim($telco))][$index])) {
            $index = 0;
        }

        return [
            'index' => $index,
            'keyword_info' => self::KEYWORDS_PUSH[strtoupper(trim($provider))][strtoupper(trim($telco))][$index],
        ];
    }

    /**
     * Used for case set next kw index
     *
     * @param $provider
     * @param $telco
     * @param $index
     * @return null
     */
    public static function setKwIndex($provider, $telco, $index)
    {
        if (empty(self::KEYWORDS_PUSH[strtoupper(trim($provider))][strtoupper(trim($telco))])) {
            return null;
        }

        $provider = strtolower($provider);
        $telco = strtolower($telco);

        $key = self::getKeyRedisKwIndex($provider, $telco);
        $index = intval($index);
        Redis::set($key, $index);
    }

    public static function getNextKeywordF2U() {}

    public static function pickKwMK($telco)
    {
        //todo: get current kw
        ///then => push data onesignal
        /// then => increase index
        /// => call setKwIndex with new index

        return self::pickKw(self::KW_MK, $telco);
    }

    public static function pickKwF2U($telco)
    {
        //todo: get current kw
        ///then => push data onesignal
        /// then => increase index
        /// => call setKwIndex with new index

        return self::pickKw(self::KW_F2U, $telco);
    }

    private static function pickKw($provider, $telco)
    {
        $currentKw = self::getCurrentKw($provider, $telco);

        $kw = $currentKw['keyword_info'];
        if ($telco == self::TELCO_AIS) {
            $kw['shortcode'] = '+' . $kw['shortcode'];
        }

        $nextIndex = ($currentKw['index'] + 1);
        self::setKwIndex($provider, $telco, $nextIndex);

        return $kw;
    }


    private static function getKeyRedisKwIndex($provider, $telco)
    {
        return sprintf(self::KEY_CACHE_PUSH_PREFIX . '%s_%s', $provider, $telco);
    }
}
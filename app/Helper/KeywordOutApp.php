<?php


namespace App\Helper;

use Illuminate\Support\Facades\Redis;

class KeywordOutApp
{
    const KW_MK = 'MK';
    const KW_F2U = 'F2U';

    const TELCO_DTAC = 'DTAC';
    const TELCO_AIS = 'AIS';

    ///Note F2U
    //
    //AIS, DTAC, TRUE
    //J1_4761469
    //M1_4761597
    //Q1_4761601
    //K1_4761595
    //R1_4761602
    //A1_4761590
    //
    //
    //AIS only
    //Z1_4761613
    //T1_4761604
    //G1_4761620
    //
    //(NEW)
    //X1_4761608
    //L1_4761625
    //M1_4761626
    //Z1_4761643
    //
    //
    //DTAC only
    //F1_4761619

    const KEYWORDS_PUSH = [

        self::KW_F2U => [
            self::TELCO_DTAC => [
                ///DTAC
                ///
                ///
                /// old kw
                ///
//                [
//                    'keyword' => 'A1',
//                    'shortcode' => '4761590',
//                ],
                [
                    'keyword' => 'J1',
                    'shortcode' => '4761469',
                ],
                [
                    'keyword' => 'R1',
                    'shortcode' => '4761602',
                ],
                [
                    'keyword' => 'M1',
                    'shortcode' => '4761597',
                ],
                [
                    'keyword' => 'K1',
                    'shortcode' => '4761595',
                ],
                [
                    'keyword' => 'Q1',
                    'shortcode' => '4761601',
                ],
                [
                    'keyword' => 'F1',
                    'shortcode' => '4761619',
                ],

            ],
            self::TELCO_AIS => [
                ///DTAC
                ///
                ///
                /// old kw
                //
//                [
//                    'keyword' => 'A1',
//                    'shortcode' => '4761590',
//                ],

                //new kw
                [
                    'keyword' => 'A1', //Motion Battle
                    'shortcode' => '4761644',
                ],
                [
                    'keyword' => 'K1', //Cooking Room
                    'shortcode' => '4761656',
                ],


                //temp off
                /*
                [
                    'keyword' => 'J1',
                    'shortcode' => '4761469',
                ],
                [
                    'keyword' => 'R1',
                    'shortcode' => '4761602',
                ],
                [
                    'keyword' => 'M1',
                    'shortcode' => '4761597',
                ],
                [
                    'keyword' => 'K1',
                    'shortcode' => '4761595',
                ],
                [
                    'keyword' => 'Z1',
                    'shortcode' => '4761613',
                ],
                [
                    'keyword' => 'Q1',
                    'shortcode' => '4761601',
                ],
                [
                    'keyword' => 'G1',
                    'shortcode' => '4761620',
                ],
                [
                    'keyword' => 'T1',
                    'shortcode' => '4761604',
                ],
                */


                /// new kw (ais only)
//                [
//                    'keyword' => 'X1',
//                    'shortcode' => '4761608',
//                ],
//                [
//                    'keyword' => 'L1',
//                    'shortcode' => '4761625',
//                ],
//                [
//                    'keyword' => 'M1',
//                    'shortcode' => '4761626',
//                ],
//                [
//                    'keyword' => 'Z1',
//                    'shortcode' => '4761643',
//                ],

            ],
        ],

    ];

    const KEY_CACHE_KEYWORD_OUT_APP_PREFIX = 'keyword_out_app_index_';
    const PROVIDERS = [
        self::KW_MK,
        self::KW_F2U,
    ];

    public static function pickKwF2U($telco)
    {
        //todo: get current kw
        ///then => push data onesignal
        /// then => increase index
        /// => call setKwIndex with new index

        return self::pickKw(self::KW_F2U, $telco);
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


    private static function pickKw($provider, $telco)
    {
        $currentKw = self::getCurrentKw($provider, $telco);

        $kw = $currentKw['keyword_info'];
        if ($telco == self::TELCO_AIS) {
            $kw['shortcode'] = '+'.$kw['shortcode'];
        }

        $nextIndex = ($currentKw['index'] + 1);
        self::setKwIndex($provider, $telco, $nextIndex);

        return $kw;
    }

    private static function getKeyRedisKwIndex($provider, $telco)
    {
        return sprintf(self::KEY_CACHE_KEYWORD_OUT_APP_PREFIX.'%s_%s', $provider, $telco);
    }



}

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
        return self::pickKw(self::KW_MK, $telco);
    }

    public static function pickKwF2U($telco)
    {
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

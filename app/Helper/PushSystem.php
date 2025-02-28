<?php


namespace App\Helper;

use Carbon\Carbon;

class PushSystem
{
    const SHAREWEB_DEFAULT = 60;
    const CACHE_TIME_SECONDS = 120;
    const USER_ACTIVE_PREVIOUS = 4000;
    const PUSH_INDEX_TTL_MINUTES = 120;

    public static function pickLink($shareWeb = 0)
    {
        self::getCurrentPushIndex();

        if ($shareWeb < 0 || $shareWeb > 100) {
            $shareWeb = 0;
        }

        if ($shareWeb == 0) {
            return self::pickLink1();
        }

        if ($shareWeb == 100) {
            return self::pickLink2();
        }

        $share = rand(1, 99);
        if ($share < $shareWeb) {
            return self::pickLink2();
        }

        return self::pickLink1();
    }

    public static function pickLinkApkafe()
    {
        $keyCache = self::getKeyCacheSettingPushLink('apkafe');
        $links = \Cache::store('redis')->remember($keyCache, self::CACHE_TIME_SECONDS, function () {
            return Common::file2Array(storage_path('onesignal/config_link_push/apkafe.txt'));
        });

        if (empty($links)) {
            \Cache::store('redis')->forget($keyCache);

            return null;
        }

        return $links[array_rand($links)];
    }

    public static function pickLinkVni()
    {
        $keyCache = self::getKeyCacheSettingPushLink('vni');
        $links = \Cache::store('redis')->remember($keyCache, self::CACHE_TIME_SECONDS, function () {
            return Common::file2Array(storage_path('onesignal/config_link_push/vni.txt'));
        });

        if (empty($links)) {
            \Cache::store('redis')->forget($keyCache);

            return null;
        }

        return $links[array_rand($links)];
    }

    public static function getKeyCacheSettingPushLink($linkType)
    {
        return 'push_system_link_' . strtolower(trim($linkType));
    }

    public static function pickLink1()
    {
        $pushIndex = self::getCurrentPushIndex();
        $keyCache = self::getKeyCacheSettingPushLink('apkafe');
        $links = \Cache::store('redis')->remember($keyCache, self::CACHE_TIME_SECONDS, function () use ($pushIndex) {
            $data = \DB::table('push_systems_config_new')->where('push_count', $pushIndex)->first();
            $configLinks = !empty($data->config_links) ? json_decode($data->config_links, true) : [];

            $links1 = [];
            if (!empty($configLinks['link_push_1'])) {
                $links1 = $configLinks['link_push_1'];
            }

            if (empty($links1)) {
                return array_filter(Common::file2Array(storage_path('onesignal/config_link_push/apkafe.txt')));
            }

            return array_filter($links1);
        });

        if (empty($links)) {
            \Cache::store('redis')->forget($keyCache);

            return null;
        }

        return $links[array_rand($links)];
    }

    public static function pickLink2()
    {
        $pushIndex = self::getCurrentPushIndex();
        $keyCache = self::getKeyCacheSettingPushLink('vni');
        $links = \Cache::store('redis')->remember($keyCache, self::CACHE_TIME_SECONDS, function () use ($pushIndex) {
            $data = \DB::table('push_systems_config_new')->where('push_count', $pushIndex)->first();
            $configLinks = !empty($data->config_links) ? json_decode($data->config_links, true) : [];
            $links2 = [];
            if (!empty($configLinks['link_push_2'])) {
                $links2 = $configLinks['link_push_2'];
            }

            if (empty($links2)) {
                return array_filter(Common::file2Array(storage_path('onesignal/config_link_push/vni.txt')));
            }

            return array_filter($links2);
        });

        if (empty($links)) {
            \Cache::store('redis')->forget($keyCache);

            return null;
        }

        return $links[array_rand($links)];
    }

    public static function getShareWebConfig()
    {
        $keyCache = self::getKeyCacheSettingPushLink('shareweb');
        $pushIndex = self::getCurrentPushIndex();

        $shareWeb = \Cache::store('redis')->remember($keyCache, self::CACHE_TIME_SECONDS, function () use ($pushIndex) {

            $data = \DB::table('push_systems_config_new')->where('push_count', $pushIndex)->first('share');
            if (empty($data)) {
                return self::SHAREWEB_DEFAULT;
            }

            return intval($data->share);
        });

        return intval($shareWeb);
    }

    public static function getCurrentPushIndex()
    {
        $info = \Cache::store('redis')->get(self::getKeyCacheCurrentPushIndex());

        if (empty($info)) {
            self::setCurrentPushIndex(1);

            return 1;
        }

        $activate = $info['activated_at'] ?? Common::getCurrentVNTime();
        $currentPushIndex = $info['index'] ?? 0;

        $start = new Carbon($activate);
        $end = new Carbon(Common::getCurrentVNTime());
        $diffMinutes = $end->diffInMinutes($start);

        if ($diffMinutes >= self::PUSH_INDEX_TTL_MINUTES) {
            $nextIndex = $currentPushIndex + 1;
            if ($nextIndex > self::getMaxPushSystemIndex()) {
                $nextIndex = 1;
            }

            self::setCurrentPushIndex($nextIndex);

            return $nextIndex;
        }

        return $currentPushIndex;
    }

    public static function setCurrentPushIndex($pushIndex)
    {
        $data = [
            'index' => $pushIndex,
            'activated_at' => Common::getCurrentVNTime(),
        ];

        \Cache::store('redis')->set(self::getKeyCacheCurrentPushIndex(), $data);
    }

    public static function getMaxPushSystemIndex()
    {
        $keyCache = self::getKeyCacheMaxPushSystemIndex();
        $maxPushIndex = \Cache::store('redis')->remember($keyCache, self::CACHE_TIME_SECONDS, function () {
            $maxPushIndex = \DB::table('push_systems_config_new')->select(\DB::raw('max(push_count) as push_index'))->first('push_index');

            return !empty($maxPushIndex) ? intval($maxPushIndex->push_index) : 0;
        });

        return intval($maxPushIndex);
    }

    private static function getKeyCacheCurrentPushIndex()
    {
        return 'push_system_link_push_index';
    }

    private static function getKeyCacheMaxPushSystemIndex()
    {
        return 'push_system_link_max_push_index';
    }

    public static function getPushStatusAndTypeConfig()
    {
        $keyCache = self::getKeyCacheSettingPushLink('status_type');
        $configStatusType = \Cache::store('redis')->remember($keyCache, self::CACHE_TIME_SECONDS, function () {
            $data = \DB::table('push_systems_config_new')->where('push_count', 0)->first();
            if (empty($data)) {
                return [
                    'status' => 'on',
                    'type' => 'search',
                ];
            }

            return [
                'status' => $data->status,
                'type' => $data->type,
            ];
        });

        return $configStatusType;
    }
}

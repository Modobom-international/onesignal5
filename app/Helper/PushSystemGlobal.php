<?php


namespace App\Helper;


class PushSystemGlobal
{
    const SHAREWEB_DEFAULT = 60; //vni 60%, apkafe 40%
    const CACHE_TIME_SECONDS = 120; //2 minutes
    const USER_ACTIVE_PREVIOUS = 4000;
    public static function pickLink($shareWeb = 0)
    {
        if ($shareWeb < 0 || $shareWeb > 100) {
            $shareWeb = 0;
        }

        if ($shareWeb == 0) {
            //pick link apkafe
            //return self::pickLinkApkafe();
            return self::pickLink1();
        }

        if ($shareWeb == 100) {
            //pick link vni
            //return self::pickLinkVni();
            return self::pickLink2();
        }


        //Note:
        //- random [1-99] nếu giá trị nhận dc bé hơn shareweb thì hiển thị vnifood

        $share = rand(1, 99);
        if ($share < $shareWeb) {
            //return self::pickLinkVni();
            return self::pickLink2();
        }

        //return self::pickLinkApkafe();
        return self::pickLink1();
    }

    public static function getKeyCacheSettingPushLink($linkType)
    {
        return 'push_system_link_global_'.strtolower(trim($linkType));
    }


    /***
     * Pick link 1 (apkafe)
     *
     * @return mixed|null
     */
    public static function pickLink1()
    {
        $keyCache = self::getKeyCacheSettingPushLink('apkafe');
        $links = \Cache::store('redis')->remember($keyCache, self::CACHE_TIME_SECONDS, function () {

            $data = \DB::table('push_systems_global_config_new')->first();

            if (empty($data)) {
                //get links from file
                return Common::file2Array(storage_path('onesignal/config_link_push/apkafe.txt'));
            }

            return json_decode($data->link_web_1, true);

        });

        if (empty($links)) {

            //remove cache if empty
            \Cache::store('redis')->forget($keyCache);

            return null;
        }

        return $links[array_rand($links)];
    }

    /***
     * Pick link 2 (vni)
     *
     * @return mixed|null
     */
    public static function pickLink2()
    {
        $keyCache = self::getKeyCacheSettingPushLink('vni');

        $links = \Cache::store('redis')->remember($keyCache, self::CACHE_TIME_SECONDS, function () {
            $data = \DB::table('push_systems_global_config_new')->first();

            if (empty($data)) {
                //get links from file
                return Common::file2Array(storage_path('onesignal/config_link_push/vni.txt'));
            }

            return json_decode($data->link_web_2, true);
        });

        if (empty($links)) {
            //remove cache if empty
            \Cache::store('redis')->forget($keyCache);

            return null;
        }

        return $links[array_rand($links)];
    }

    public static function getShareWebConfig()
    {
        $keyCache = self::getKeyCacheSettingPushLink('shareweb');

        $shareWeb = \Cache::store('redis')->remember($keyCache, self::CACHE_TIME_SECONDS, function () {

            $data = \DB::table('push_systems_global_config_new')->first('share');
            if (empty($data)) {
                return self::SHAREWEB_DEFAULT;
            }

            return intval($data->share);
        });

        return intval($shareWeb);
    }


}

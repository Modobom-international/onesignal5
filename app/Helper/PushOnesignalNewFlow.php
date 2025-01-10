<?php

namespace App\Helper;

use App\Jobs\SavePushOnesignalHistory;
use Illuminate\Support\Facades\Redis;

class PushOnesignalNewFlow
{
    const KEY_REDIS_PUSH_PREFIX = 'push_onesignal_new_flow_';
    const KEY_REDIS_CURRENT_PACKAGE_PREFIX = 'push_onesignal_new_flow_current_package_';
    const KEY_REDIS_CURRENT_LINK_INDEX_WITH_PACKAGE_PREFIX = 'push_onesignal_new_flow_current_link_index_with_package_';
    const KEY_REDIS_PUSH_TLL = 60 * 60 * 24 * 365; //365 days
//    const KEY_REDIS_PUSH_TLL = 12; //10s
    const LIMIT_USERS_IN_PACKAGE = 1000;

    public static function isUserAvailableForPush($version, $playerId, $linkType)
    {
        $key = self::getKeyRedisPush($version, $playerId, $linkType);

        return empty(Redis::get($key));
    }

    public static function getKeyRedisPush($version, $playerId, $linkType)
    {
        //laravel_database_push_onesignal_new_flow_v1_1234_apkafe

        return sprintf(self::KEY_REDIS_PUSH_PREFIX.'%s_%s_%s', strtolower($version), strtolower($playerId), strtolower($linkType));
    }

    public static function setKeyRedisPush($version, $playerId, $linkType)
    {
        $key = self::getKeyRedisPush($version, $playerId, $linkType);

        Redis::setex($key, self::KEY_REDIS_PUSH_TLL, '1');

    }

    public static function getPushCurrentPackageNumber($version, $linkType)
    {
        $key = self::getRedisKeyCurrentPackageNumber($version, $linkType);

        return intval(Redis::get($key));
    }

    public static function setPushCurrentPackageNumber($version, $linkType, $packageNumber)
    {
        $key = self::getRedisKeyCurrentPackageNumber($version, $linkType);

        Redis::setex($key, self::KEY_REDIS_PUSH_TLL, $packageNumber);
    }

    public static function getRedisKeyCurrentPackageNumber($version, $linkType)
    {
        $key = sprintf(self::KEY_REDIS_CURRENT_PACKAGE_PREFIX.'%s_%s', strtolower($version), strtolower($linkType));
        dump($key);

        return $key;
    }

    public static function getRedisKeyCurrentLinkIndexWithPackageNumber($version, $linkType, $packageNumber)
    {
        $key = sprintf(self::KEY_REDIS_CURRENT_LINK_INDEX_WITH_PACKAGE_PREFIX.'%s_%s_%s', strtolower($version), strtolower($linkType), $packageNumber);
        dump($key);

        return $key;
    }

    public static function getPushCurrentLinkIndex($version, $linkType, $packageNumber)
    {
        $key = self::getRedisKeyCurrentLinkIndexWithPackageNumber($version, $linkType, $packageNumber);

        return intval(Redis::get($key));
    }

    public static function setPushCurrentLinkIndex($version, $linkType, $packageNumber, $currentLinkIndex)
    {
        $key = self::getRedisKeyCurrentLinkIndexWithPackageNumber($version, $linkType, $packageNumber);
        Redis::set($key, $currentLinkIndex);
    }


    public static function assignPackageNumber($version, $playersId, $limit = 1000)
    {

        \DB::transaction(function () use ($version, $playersId, $limit) {

            $tablePlayers = self::getTablePlayers($version);

            \DB::table($tablePlayers)->update([
                'package_number' => null,
            ]);

            $i = 0;
            $packageNumber = 1;

            while (true) {

                dump('i = '.$i);
                dump('package number = '.$packageNumber);

                $offset = $i * $limit;
                $arr = array_slice($playersId, $offset, $limit);
                dump('count: '.count($arr));
                if (count($arr) == 0) {
                    break;
                }

                $dataUpdate = [
                    'package_number' => $packageNumber,
                ];

                //save DB

                \DB::table($tablePlayers)->whereIn('player_id', $arr)->update($dataUpdate);
                dump('inserted success');

                $i++;
                $packageNumber++;
            }

        });

    }

    public static function getMaxPackageNumber($version)
    {
        $tablePlayers = self::getTablePlayers($version);

        return intval(\DB::table($tablePlayers)->max('package_number'));
    }

    /**
     * Get players id by package number & link type
     *
     * @param $version
     * @param $linkType
     * @param $packageNumber
     * @param $limitPerDay
     * @return array
     */
    public static function getPlayersIdByPackageNumber($version, $linkType, $packageNumber, $limitPerDay = 1)
    {
        $tablePlayers = self::getTablePlayers($version);
        $linkType = strtolower($linkType);

        //todo: lấy time push apkafe làm mốc, linkType == vni || linkType == ryori

        $columnPushTypeCountToday = 'count_pushed_'.strtolower($linkType).'_today'; //count_pushed_apkafe_today

        $query = \DB::table($tablePlayers)->where($columnPushTypeCountToday, '<', $limitPerDay)->where('package_number', $packageNumber); //->pluck('player_id')->toArray();
        if (in_array($linkType, ['vni', 'ryori'])) {
            $timeDiff = Onesignal::PUSH_TIME_DIFF_MINUTES[$linkType] ?? 0;

            $query->whereRaw('(TIMESTAMPDIFF(minute, pushed_apkafe_at, now()) >= ?)', [$timeDiff]);
        }

        if (in_array($linkType, ['html5'])) {
            $timeDiff = Onesignal::PUSH_TIME_DIFF_MINUTES[$linkType] ?? 0;

            $query->whereRaw(' (TIMESTAMPDIFF(minute, pushed_html5_at, now()) >= ? or pushed_html5_at is null) ', [$timeDiff]);
        }

        $tmp = $query->toSql();
        dump($tmp);

        return $query->pluck('player_id')->toArray();
    }

    public static function isPackageNumberExist($version, $packageNumber)
    {
        $tablePlayers = self::getTablePlayers($version);

        $row = \DB::table($tablePlayers)->where('package_number', $packageNumber)->first();

        return !empty($row);
    }

    public static function getTablePlayers($version)
    {
        $tablePlayers = 'onesignal_player_ids';
        if ($version != Onesignal::VERSION_1) {
            $tablePlayers = $tablePlayers.'_'.$version;
        }

        return $tablePlayers;
    }

    public static function getMessagesByLinkType($country, $linkType, $version, $packageNumber = null)
    {
        if (strtolower($linkType) == 'vni' || strtolower($linkType) == 'ryori' || strtolower($linkType) == 'html5') {
            return Onesignal::generateOnesignalMessage($linkType, $version, $packageNumber);
        }

        $file = storage_path(sprintf('onesignal/data/%s/link-type/%s.txt', $country, strtolower($linkType)));
        dump($file);
        if (!is_file($file)) {
            dump('Country or link type is invalid!');

            return null;
        }

        $messages = file_get_contents($file);
        $tmp = json_decode($messages, true);

        $message = null;
        if (!empty($tmp)) {
            shuffle($tmp);
            $message = $tmp[array_rand($tmp)];

            $message['title']['en'] = 'Title';

        }

        if (empty($message)) {
            dump('Message is null, nothing to do!');

            return null;
        }

        return $message;
    }

    public static function savePushHistory($country, $version, $playersId, $packageNumber, $linkType, $message, $dataType = 'web')
    {

        $dataInsert = [];
        foreach ($playersId as $playId) {
            $dataInsert[] = [
                'player_id' => $playId,
                'country' => $country,
                'type' => $dataType,
                'package_number' => $packageNumber,
                'link_type' => $linkType,
                'content' => json_encode($message),
                'pushed_at' => Common::getCurrentVNTime(),
                'pushed_date' => Common::getCurrentVNTime('Y-m-d'),
            ];

        }

        SavePushOnesignalHistory::dispatch($dataInsert, $version)->onQueue('save_push_onesignal_history');

        //save detail info for each player id
        $tablePlayers = self::getTablePlayers($version);

        $columnCount = 'count_pushed_'.strtolower($linkType).'_today';
        $columnAt = 'pushed_'.strtolower($linkType).'_at';

        \DB::table($tablePlayers)->whereIn('player_id', $playersId)->increment($columnCount);
        \DB::table($tablePlayers)->whereIn('player_id', $playersId)->update([
            $columnAt => Common::getCurrentVNTime(),
        ]);

    }

    public static function getNextLink($country, $version, $linkType, $currentLinkIndex)
    {
        ///input: current index, list links
        ///
        ///
        ///


    }

    public static function getLinkIndexByPlayerId($country, $version, $playerId, $linkType)
    {
        $tablePlayers = self::getTablePlayers($version);
        $linkType = strtolower($linkType);

        $info = \DB::table($tablePlayers)
            ->where('country', $country)
            ->where('player_id', $playerId)
            ->first();

        $linkIndex = 0;
        if (!empty($info)) {
            $column = 'link_'.$linkType.'_index';

            $linkIndex = $info->$column;
        }

        return intval($linkIndex);
    }

}

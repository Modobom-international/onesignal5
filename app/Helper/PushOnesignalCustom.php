<?php


namespace App\Helper;


class PushOnesignalCustom
{
    const LIMIT_PERCENT = 5; //5%

    const LINKS = [
        'https://grannygames.net/top-5-car-gta-v-mods-to-play/',
        'https://gamemuchs.com/a-tale-of-two-cities-contrasting-the-worlds-of-gta-iv-and-gta-v/',
        //add more links

    ];

    public static function pushCustomLink($link, $country = 'thailand')
    {
        $playersId = self::getPlayersIdForPush();

        $message = [
            'type' => 'search',
            'keysearch' => 'gta5 grannygames.net',
            'site' => $link,
        ];

        $version = Onesignal::VERSION_2;

        dump($message);
        $response = Onesignal::sendNotificationByIds($country, json_encode($message), $playersId, $version);
        dump('Push response: ');
        dump($response);

        if (!empty($response)) {
            self::markPlayersIdPushedToday($playersId, $link);
        }

    }

    ///cho push vào 2 links này từ hidden app cho anh
    //
    //1. https://grannygames.net/top-5-car-gta-v-mods-to-play/
    //2. https://gamemuchs.com/a-tale-of-two-cities-contrasting-the-worlds-of-gta-iv-and-gta-v/
    //
    //sáng 1 nháy nhẹ
    //chiều 1 nháy nhẹ
    //
    //10-20% đừng push nhiều quá ha

    ///todo: lấy list player id từ table onesignal_player_ids_v2,
    ///  => sáng lấy ra 5% users push link 1, 5% user push link 2 (check chưa push hnay)
    /// => chiều lấy ra 5% users push link 1, 5% user push link 2 (check chưa push hnay)

    public static function getPlayersIdForPush()
    {
        //=> sáng lấy ra 5% users push link 1, 5% user push link 2 (check chưa push hnay)

        //get history pushed today
        $playersIdPushToday = \DB::table('onesignal_push_custom_history')
            ->where('pushed_date', Common::getCurrentVNTime('Y-m-d'))
            ->pluck('player_id');

        $playersIdNeedPush = \DB::table('onesignal_player_ids_v2')->whereNotIn('player_id', $playersIdPushToday)->pluck('player_id')->toArray();

        $countPickedUsers = round(count($playersIdNeedPush) * self::LIMIT_PERCENT / 100);
        shuffle($playersIdNeedPush);

        return array_slice($playersIdNeedPush, 0, $countPickedUsers);
    }

    public static function markPlayersIdPushedToday($playersId, $link)
    {
        $dataInsert = [];

        foreach ($playersId as $playerId) {
            $dataInsert[] = [
                'player_id' => $playerId,
                'link' => $link,
                'pushed_at' => Common::getCurrentVNTime(),
                'pushed_date' => Common::getCurrentVNTime('Y-m-d H:i:s'),
            ];

        }

        if(empty($dataInsert)) {
            return false;
        }

        //save players id pushed history
        try {
            return \DB::table('onesignal_push_custom_history')->insert($dataInsert);

        } catch (\Exception $ex) {
            return false;
        }
    }


}

<?php


namespace App\Helper;

use App\Constants;

class MalaysiaSubs
{

    public static function getSubsTodayMalaysia()
    {
        $kwConfig = Constants::MALAYSIA_KEYWORDS;

        $result = [];
        foreach ($kwConfig as $kw => $url) {
            $today = (new \DateTime('now', new \DateTimeZone('Asia/Ho_Chi_Minh')))->format('d-m-Y'); //romania

            $urlReport = $url;
            $urlReport = str_replace('@@TODAY@@', $today, $urlReport);

            $subsData = Common::callUrl($urlReport, []);

            $arr = json_decode($subsData, true);
            $result[$kw] = $arr['extra']['today'] ['mo reg']['all'];
        }

        return $result;

    }

}

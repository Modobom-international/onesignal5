<?php


namespace App\Helper\Report;


class PushSystem
{
    public static function getCountries()
    {
        return \DB::table('push_systems')
            ->select(\DB::raw('distinct country as country'))
            ->whereNotNull('country')
            ->get()->pluck('country');

    }

    public static function getAppsForSelect($country, $platform)
    {
        $query = \DB::table('push_systems')
            ->select(\DB::raw('distinct app'))
            ->whereNotNull('app');

        if (!empty($country)) {
            $query->where('country', $country);
        }
        if (!empty($platform)) {
            $query->where('platform', $platform);
        }

        return $query->get()->pluck('app');
    }

}

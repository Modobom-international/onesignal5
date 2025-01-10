<?php


namespace App\Helper;


class AmazonDownloader
{
    public static function saveCacheKey($cacheKey, $url, $country, $platform, $appId, $version)
    {
        $dataInsert = [
            'key' => $cacheKey,
            'value' => $url,
            'country' => $country,
            'platform' => $platform,
            'app_id' => $appId,
            'version' => $version,
            'created_at' => Common::getCurrentVNTime(),
            'created_date' => Common::getCurrentVNTime('Y-m-d'),
        ];

        \DB::table('amazon_files_built_key_caches_history')->insert($dataInsert);

        //only save key one row, if key exist, update it
        $row = \DB::table('amazon_files_built_key_caches')
            ->where('key', $cacheKey)
            ->first();

        if (!empty($row)) {
            //update
            \DB::table('amazon_files_built_key_caches')
                ->where('key', $cacheKey)
                ->update([
                    'value' => $url,
                    'updated_at' => Common::getCurrentVNTime(),
                ]);

        } else {
            //insert
            \DB::table('amazon_files_built_key_caches')->insert($dataInsert);

        }

    }

}

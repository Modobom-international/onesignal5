<?php


namespace App\Helper;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Common
{
    public static function getCurrentVNTime($format = 'Y-m-d H:i:s')
    {
        return self::getCurrentTime('Asia/Ho_Chi_Minh', $format);
    }

    public static function getCurrentTime($timezone = 'UTC', $format = 'Y-m-d H:i:s')
    {
        return (new \DateTime())->setTimezone(new \DateTimeZone($timezone))->format($format);
    }

    public static function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (trim($dir) == '/' || $dir == '/home' || $dir == '/root') {
            return false;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!self::deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }

    public static function covertDateTimeToMongoBSONDateGMT7($date)
    {
        return new \MongoDB\BSON\UTCDateTime(((new \DateTime($date))->getTimestamp() + (7 * 3600)) * 1000);
    }

    public static function paginate($items, $perPage = 15, $path = null, $pageName = 'page', $page = null, $options = [])
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $options = ['path' => $path];

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    function generate_uuid()
    {
        $data = openssl_random_pseudo_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

        return $uuid;
    }

    public static function getDomainFromUrl($url)
    {
        $arr = parse_url($url);

        if (!empty($arr['host'])) {
            return $arr['host'];
        }

        return null;
    }

    public static function uniqidReal($length = 13)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
        } else {

            return ApkBuilder::getUniqueStr();
        }

        return substr(bin2hex($bytes), 0, $length);
    }
}

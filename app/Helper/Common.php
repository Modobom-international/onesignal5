<?php


namespace App\Helper;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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

    public static function exportURLAndPinFromMSGMalaysia($message)
    {
        $export = [
            'pin' => '',
            'url' => ''
        ];

        $explodeForPin = explode('Your TAC is ', $message);
        $explodeForPin2 = explode('.', $explodeForPin[1]);
        $regex = '/^[0-9]{4}$/';
        $pre_match = preg_match($regex, $explodeForPin2[0], $matchesPin);
        if ($pre_match > 0) {
            $export['pin'] = $matchesPin[0];
        }

        $explodeForURL = explode('go to ', $message);
        $explodeForURL2 = explode(' in your', $explodeForURL[1]);
        $export['url'] = $explodeForURL2[0];

        return $export;
    }

    public static function exportURLAndPinFromDenmark($url)
    {
        $export = [
            'pin' => '',
            'url' => ''
        ];

        preg_match("/&?otp=([^&]+)/", $url, $matches);

        $export['url'] = $url;
        $export['pin'] = $matches[1];

        return $export;
    }

    public function renderLogoForDomain($sourcePath)
    {
        $scriptPath = public_path('bash/logo_render.sh');
        $ipServer = env('IP_ORIGIN_SERVER', '127.0.0.1');

        $command = [
            'rsync',
            '-avzhe',
            'ssh',
            '/binhchay/images/sspaps-1.png',
            "root@{$ipServer}:{$sourcePath}"
        ];

        try {
            $process = new Process(['bash', $scriptPath]);
            $process->setTimeout(600);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            $scriptOutput = $process->getOutput();

            $process = new Process($command);
            $process->setTimeout(600);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $rsyncOutput = $process->getOutput();

            return response()->json([
                'status' => 'success',
                'script_output' => $scriptOutput,
                'rsync_output' => $rsyncOutput,
            ]);
        } catch (ProcessFailedException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'error_output' => $e->getProcess()->getErrorOutput(),
            ], 500);
        }
    }
}

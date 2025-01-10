<?php


namespace App\Helper;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Http\File;

class LinodeStorageObject
{

    const COUNTRY_THAILAND = 'thailand';
    const COUNTRY_EU = 'eu';

    const TOTAL_LINKS_PER_APP = 4;

    const KEY_LINODE_ACCESS_KEY = 'linode_access_key';
    const KEY_LINODE_SECRET_KEY = 'linode_secret_key';
    const KEY_LINODE_PROFILE = 'linode_profile';
    const KEY_LINODE_REGION = 'linode_region';
    const KEY_LINODE_BUCKET_PREFIX = 'linode_bucket_prefix';
    const KEY_LINODE_ENDPOINT = 'linode_endpoint';

    const LINODE_CREDENTIALS = [
        self::COUNTRY_THAILAND => [
            [ //index 0
                self::KEY_LINODE_ACCESS_KEY => 'ZLEEJT45JQVAIRTU0POB', //acc: vylinh49
                self::KEY_LINODE_SECRET_KEY => 'C9grlVFyTriRxf8iCVY66EJs9LlCXpXFhpryjkmu',
                self::KEY_LINODE_REGION => 'ap-south-1', //singapore
                self::KEY_LINODE_PROFILE => 'thailand_index_0',
                self::KEY_LINODE_BUCKET_PREFIX => 'thi0',
                self::KEY_LINODE_ENDPOINT => 'https://ap-south-1.linodeobjects.com',

            ],
            [ //index 1
                self::KEY_LINODE_ACCESS_KEY => 'ZLEEJT45JQVAIRTU0POB', //acc: vylinh49
                self::KEY_LINODE_SECRET_KEY => 'C9grlVFyTriRxf8iCVY66EJs9LlCXpXFhpryjkmu',
                self::KEY_LINODE_REGION => 'jp-osa-1', //japan
                self::KEY_LINODE_PROFILE => 'thailand_index_1',
                self::KEY_LINODE_BUCKET_PREFIX => 'thi1',
                self::KEY_LINODE_ENDPOINT => 'https://jp-osa-1.linodeobjects.com',

            ],
            [ //index 2
                self::KEY_LINODE_ACCESS_KEY => 'SIZZ07IJCH84M2JAFU8O', //acc: doanminhan458
                self::KEY_LINODE_SECRET_KEY => 'Htsyw2lgrm9Y68Qb3W21zuXq22ZcvZ7o7O3TpqOV',
                self::KEY_LINODE_REGION => 'jp-osa-1', //japan
                self::KEY_LINODE_PROFILE => 'thailand_index_2',
                self::KEY_LINODE_BUCKET_PREFIX => 'thi2',
                self::KEY_LINODE_ENDPOINT => 'https://jp-osa-1.linodeobjects.com',

            ],
            [ //index 3
                self::KEY_LINODE_ACCESS_KEY => 'ZLEEJT45JQVAIRTU0POB', //acc: vylinh49
                self::KEY_LINODE_SECRET_KEY => 'C9grlVFyTriRxf8iCVY66EJs9LlCXpXFhpryjkmu',
                self::KEY_LINODE_REGION => 'in-maa-1', //india
                self::KEY_LINODE_PROFILE => 'thailand_index_3',
                self::KEY_LINODE_BUCKET_PREFIX => 'thi3',
                self::KEY_LINODE_ENDPOINT => 'https://in-maa-1.linodeobjects.com',

            ],

        ],
        self::COUNTRY_MALAYSIA => [
            [ //index 0
                self::KEY_LINODE_ACCESS_KEY => 'SIZZ07IJCH84M2JAFU8O',
                self::KEY_LINODE_SECRET_KEY => 'Htsyw2lgrm9Y68Qb3W21zuXq22ZcvZ7o7O3TpqOV',
                self::KEY_LINODE_REGION => 'ap-south-1', //singapore
                self::KEY_LINODE_PROFILE => 'malaysia_index_0',
                self::KEY_LINODE_BUCKET_PREFIX => 'myi0',
                self::KEY_LINODE_ENDPOINT => 'https://ap-south-1.linodeobjects.com',

            ],
        ],

        self::COUNTRY_ROMANIA => [
            [ //index 0
                self::KEY_LINODE_ACCESS_KEY => '07GBEV40P41GVOWCVW8C',
                self::KEY_LINODE_SECRET_KEY => '14dGHgZCFkqu0TTquQAqeMnnYUjXweH5HbTzChPt',
                self::KEY_LINODE_REGION => 'eu-central-1', //germany
                self::KEY_LINODE_PROFILE => 'romania_index_0',
                self::KEY_LINODE_BUCKET_PREFIX => 'roi0',
                self::KEY_LINODE_ENDPOINT => 'https://eu-central-1.linodeobjects.com',

            ],
            [ //index 1
                self::KEY_LINODE_ACCESS_KEY => '07GBEV40P41GVOWCVW8C',
                self::KEY_LINODE_SECRET_KEY => '14dGHgZCFkqu0TTquQAqeMnnYUjXweH5HbTzChPt',
                self::KEY_LINODE_REGION => 'fr-par-1', //france
                self::KEY_LINODE_PROFILE => 'romania_index_1',
                self::KEY_LINODE_BUCKET_PREFIX => 'roi1',
                self::KEY_LINODE_ENDPOINT => 'https://fr-par-1.linodeobjects.com',

            ],
            [ //index 2
                self::KEY_LINODE_ACCESS_KEY => '07GBEV40P41GVOWCVW8C',
                self::KEY_LINODE_SECRET_KEY => '14dGHgZCFkqu0TTquQAqeMnnYUjXweH5HbTzChPt',
                self::KEY_LINODE_REGION => 'nl-ams-1', //amsterdam
                self::KEY_LINODE_PROFILE => 'romania_index_2',
                self::KEY_LINODE_BUCKET_PREFIX => 'roi2',
                self::KEY_LINODE_ENDPOINT => 'https://nl-ams-1.linodeobjects.com',

            ],
        ],
        self::COUNTRY_CROATIA => [
            [ //index 0
                self::KEY_LINODE_ACCESS_KEY => 'DC0Z5D4UGITVQMZANE76',
                self::KEY_LINODE_SECRET_KEY => 'uYGSQGdjQ0pHdftFVPgHyIowJw9qq6YzKuSC3aDk',
                self::KEY_LINODE_REGION => 'eu-central-1', //germany
                self::KEY_LINODE_PROFILE => 'croatia_index_0',
                self::KEY_LINODE_BUCKET_PREFIX => 'hri0',
                self::KEY_LINODE_ENDPOINT => 'https://eu-central-1.linodeobjects.com',

            ],
            [ //index 1
                self::KEY_LINODE_ACCESS_KEY => 'DC0Z5D4UGITVQMZANE76',
                self::KEY_LINODE_SECRET_KEY => 'uYGSQGdjQ0pHdftFVPgHyIowJw9qq6YzKuSC3aDk',
                self::KEY_LINODE_REGION => 'fr-par-1', //france
                self::KEY_LINODE_PROFILE => 'croatia_index_1',
                self::KEY_LINODE_BUCKET_PREFIX => 'hri1',
                self::KEY_LINODE_ENDPOINT => 'https://fr-par-1.linodeobjects.com',

            ],
            [ //index 2
                self::KEY_LINODE_ACCESS_KEY => 'DC0Z5D4UGITVQMZANE76',
                self::KEY_LINODE_SECRET_KEY => 'uYGSQGdjQ0pHdftFVPgHyIowJw9qq6YzKuSC3aDk',
                self::KEY_LINODE_REGION => 'nl-ams-1', //amsterdam
                self::KEY_LINODE_PROFILE => 'croatia_index_2',
                self::KEY_LINODE_BUCKET_PREFIX => 'hri2',
                self::KEY_LINODE_ENDPOINT => 'https://nl-ams-1.linodeobjects.com',

            ],
        ],
        self::COUNTRY_CZECH => [
            [ //index 0
                self::KEY_LINODE_ACCESS_KEY => '07GBEV40P41GVOWCVW8C',
                self::KEY_LINODE_SECRET_KEY => '14dGHgZCFkqu0TTquQAqeMnnYUjXweH5HbTzChPt',
                self::KEY_LINODE_REGION => 'se-sto-1', //stockholm
                self::KEY_LINODE_PROFILE => 'czech_index_0',
                self::KEY_LINODE_BUCKET_PREFIX => 'czi0',
                self::KEY_LINODE_ENDPOINT => 'https://se-sto-1.linodeobjects.com',

            ],
        ],
        self::COUNTRY_SLOVENIA => [
            [ //index 0
                self::KEY_LINODE_ACCESS_KEY => 'DC0Z5D4UGITVQMZANE76',
                self::KEY_LINODE_SECRET_KEY => 'uYGSQGdjQ0pHdftFVPgHyIowJw9qq6YzKuSC3aDk',
                self::KEY_LINODE_REGION => 'se-sto-1', //stockholm
                self::KEY_LINODE_PROFILE => 'slovenia_index_0',
                self::KEY_LINODE_BUCKET_PREFIX => 'sii0',
                self::KEY_LINODE_ENDPOINT => 'https://se-sto-1.linodeobjects.com',

            ],
        ],
        self::COUNTRY_DENMARK => [
            [ //index 0
                self::KEY_LINODE_ACCESS_KEY => '07GBEV40P41GVOWCVW8C',
                self::KEY_LINODE_SECRET_KEY => '14dGHgZCFkqu0TTquQAqeMnnYUjXweH5HbTzChPt',
                self::KEY_LINODE_REGION => 'es-mad-1', //ES Madrid
                self::KEY_LINODE_PROFILE => 'denmark_index_0',
                self::KEY_LINODE_BUCKET_PREFIX => 'dki0',
                self::KEY_LINODE_ENDPOINT => 'https://es-mad-1.linodeobjects.com',

            ],
        ],
        self::COUNTRY_LUXEMBOURG => [
            [ //index 0
                self::KEY_LINODE_ACCESS_KEY => 'DC0Z5D4UGITVQMZANE76',
                self::KEY_LINODE_SECRET_KEY => 'uYGSQGdjQ0pHdftFVPgHyIowJw9qq6YzKuSC3aDk',
                self::KEY_LINODE_REGION => 'es-mad-1', //ES Madrid
                self::KEY_LINODE_PROFILE => 'luxembourg_index_0',
                self::KEY_LINODE_BUCKET_PREFIX => 'lui0',
                self::KEY_LINODE_ENDPOINT => 'https://es-mad-1.linodeobjects.com',

            ],
        ],
        self::COUNTRY_MONTENEGRO => [
            [ //index 0
                self::KEY_LINODE_ACCESS_KEY => '07GBEV40P41GVOWCVW8C',
                self::KEY_LINODE_SECRET_KEY => '14dGHgZCFkqu0TTquQAqeMnnYUjXweH5HbTzChPt',
                self::KEY_LINODE_REGION => 'it-mil-1', //Milan
                self::KEY_LINODE_PROFILE => 'montenegro_index_0',
                self::KEY_LINODE_BUCKET_PREFIX => 'mei0',
                self::KEY_LINODE_ENDPOINT => 'https://it-mil-1.linodeobjects.com',

            ],
        ],
        self::COUNTRY_SWITZERLAND => [
            [ //index 0
                self::KEY_LINODE_ACCESS_KEY => 'DC0Z5D4UGITVQMZANE76',
                self::KEY_LINODE_SECRET_KEY => 'uYGSQGdjQ0pHdftFVPgHyIowJw9qq6YzKuSC3aDk',
                self::KEY_LINODE_REGION => 'it-mil-1', //ES Madrid
                self::KEY_LINODE_PROFILE => 'switzerland_index_0',
                self::KEY_LINODE_BUCKET_PREFIX => 'chi0',
                self::KEY_LINODE_ENDPOINT => 'https://it-mil-1.linodeobjects.com',

            ],
        ],

        self::COUNTRY_EU => [
            [
                self::KEY_LINODE_ACCESS_KEY => 'DC0Z5D4UGITVQMZANE76',
                self::KEY_LINODE_SECRET_KEY => 'uYGSQGdjQ0pHdftFVPgHyIowJw9qq6YzKuSC3aDk',
                self::KEY_LINODE_REGION => 'eu-central-1',
                self::KEY_LINODE_PROFILE => 'eu_index_0',
                self::KEY_LINODE_BUCKET_PREFIX => 'eui0',
                self::KEY_LINODE_ENDPOINT => 'https://eu-central-1.linodeobjects.com',

            ],
        ],


        self::COUNTRY_GENERAL => [ //like country THAILAND - INDEX 3
            [
                self::KEY_LINODE_ACCESS_KEY => 'ZLEEJT45JQVAIRTU0POB', //acc: vylinh49
                self::KEY_LINODE_SECRET_KEY => 'C9grlVFyTriRxf8iCVY66EJs9LlCXpXFhpryjkmu',
                self::KEY_LINODE_REGION => 'in-maa-1', //india
                self::KEY_LINODE_PROFILE => 'thailand_index_3',
                self::KEY_LINODE_BUCKET_PREFIX => 'thi3',
                self::KEY_LINODE_ENDPOINT => 'https://in-maa-1.linodeobjects.com',

            ],
        ],
    ];

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

    //const CACHE_TIME_LINK_APK_MINUTES = 3; //5 minutes
    const CACHE_TIME_LINK_APK_MINUTES = 10; //1 day

    //const CACHE_TIME_LINK_APK_MINUTES_SHORT = 3; //5 minutes
    const CACHE_TIME_LINK_APK_MINUTES_SHORT = 10; //1 day
    const CACHE_TIME_LINK_STORE_MINUTES = 15; //15 minutes

    const FILE_STATUS_NEW = 'new';
    const FILE_STATUS_CHECKING = 'checking';
    const FILE_STATUS_CHECKED = 'checked';

    const FILE_CHECK_NEW_TIMEOUT_MINUTES = 5;

    const CHECK_FILE_TIMEOUT_MINUTE = 3;

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

    public static function getCredential($country, $awsAccountIndex = 0, $key = null)
    {
        $country = strtolower($country);

        if (empty(self::LINODE_CREDENTIALS[$country]) || empty(self::LINODE_CREDENTIALS[$country][$awsAccountIndex])) {
            return null;
        }

        if (empty($key)) {
            return self::LINODE_CREDENTIALS[$country][$awsAccountIndex];
        }

        return self::LINODE_CREDENTIALS[$country][$awsAccountIndex][$key] ?? null;
    }

    public static function createBucket(S3Client $s3Client, $bucketName, $showDebug = true)
    {
        try {
            $result = $s3Client->createBucket([
                'Bucket' => $bucketName,
                'ObjectOwnership' => 'ObjectWriter',
                'CreateBucketConfiguration' => [
                    'LocationConstraint' => 'default', //important
                ],
                //'ACL' => 'public-read-write',
            ]);

            if ($showDebug) {
                if (!empty($result['Location'])) {

                    dump('['.Common::getCurrentVNTime().'] The bucket\'s location is: '.
                        $result['Location'].'. '.
                        'The bucket\'s effective URI is: '.
                        $result['@metadata']['effectiveUri']."\n");
                }
            }

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
     * @param int $accountAwsIndex
     * @param $bucket
     * @param bool $showDebug
     * @return bool
     */
    public static function createTheBucket($country, $bucket, $accountAwsIndex = 0, $showDebug = true)
    {
        $credentials = self::getCredential($country, $accountAwsIndex);

        $accessKey = $credentials[self::KEY_LINODE_ACCESS_KEY];
        $secretKey = $credentials[self::KEY_LINODE_SECRET_KEY];
        $region = $credentials[self::KEY_LINODE_REGION];
        $endpoint = $credentials[self::KEY_LINODE_ENDPOINT];

        $s3Client = new S3Client([
            //'profile' => $profile, //todo: get dynamic from config; default = thailand
            'suppress_php_deprecation_warning' => true,
            'region' => $region,
            'version' => 'latest',
            'acl' => 'public-read-write',
            'endpoint' => $endpoint, //important
            'credentials' => [ //todo: important!!!
                'key' => $accessKey,
                'secret' => $secretKey,
            ],
        ]);

        return self::createBucket($s3Client, $bucket, $showDebug);
    }

    public static function deleteBucket(S3Client $s3Client, $bucketName, $country)
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
     * @param $awsAccountIndex
     * @param $bucket
     */
    public static function deleteTheBucket($country, $awsAccountIndex = 0, $bucket = null)
    {
        $credentials = self::getCredential($country, $awsAccountIndex);

        $accessKey = $credentials[self::KEY_LINODE_ACCESS_KEY];
        $secretKey = $credentials[self::KEY_LINODE_SECRET_KEY];
        $region = $credentials[self::KEY_LINODE_REGION];
        $endpoint = $credentials[self::KEY_LINODE_ENDPOINT];

        $s3Client = new S3Client([
            //'profile' => $profile, //todo: get dynamic from config; default = thailand
            'suppress_php_deprecation_warning' => true,
            'region' => $region,
            'version' => 'latest',
            'endpoint' => $endpoint, //important
            'credentials' => [ //todo: important!!!
                'key' => $accessKey,
                'secret' => $secretKey,
            ],
        ]);

        return self::deleteBucket($s3Client, $bucket, $country);
    }

    /**
     * Save file to Linode Storage and return url file result
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
     * Get Linode drive (used for upload file)
     *
     * @param $country
     * @param int $accountAwsIndex
     * @param null $bucketName
     * @return \Illuminate\Contracts\Filesystem\Cloud
     */
    public static function getS3Drive($country, $accountAwsIndex = 0, $bucketName = null)
    {
        $credentials = self::getCredential($country, $accountAwsIndex);

        $accessKey = $credentials[self::KEY_LINODE_ACCESS_KEY];
        $secretKey = $credentials[self::KEY_LINODE_SECRET_KEY];
        $region = $credentials[self::KEY_LINODE_REGION];
        $endpoint = $credentials[self::KEY_LINODE_ENDPOINT];

        $config = [
            'driver' => 's3',
            'suppress_php_deprecation_warning' => true,
            'region' => $region,
            'endpoint' => $endpoint, //important
            'acl' => 'public-read-write',
            //'acl' => 'public-read',
            'visibility' => 'public', //important (allow public request access file)
            'credentials' => [
                'key' => $accessKey,
                'secret' => $secretKey,
            ],
            //'profile' => $profile,
        ];

        if (!empty($bucketName)) {
            $config['bucket'] = $bucketName;
        }

        /** @var Cloud $storage */
        $storage = \Storage::createS3Driver($config);

        return $storage;
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
        $buildApkTable = self::getTableBuiltLinks($version);

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
        $bucketPrefix = self::getCredential($country, $accountAwsIndex, self::KEY_LINODE_BUCKET_PREFIX);

        return Common::uniqidReal().$bucketPrefix;
    }

    public static function saveBucketInfo($country, $bucket, $awsAccountIndex = 0, $active = true)
    {
        $bucketPrefix = self::getCredential($country, $awsAccountIndex, self::KEY_LINODE_BUCKET_PREFIX);
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
        $tableLinks = self::getTableBuiltLinks($version);

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

        return in_array(trim($parts[1]), self::GOOGLE_REPORT_LIVE_SIGNALS);

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
            $tableLinks = self::getTableBuiltLinks($version);

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

        $tableBuild = self::getTableBuiltLinks($version);

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
        if (empty(self::LINODE_CREDENTIALS[$country][$awsAccIndex])) {
            return 'default';
        }

        return self::LINODE_CREDENTIALS[$country][$awsAccIndex][self::KEY_LINODE_PROFILE]; //self::KEY_LINODE_PROFILE
    }

    public static function pickDomainDownload($country)
    {
        $countryCode = !empty(self::COUNTRY_CODES[$country]) ? strtolower(self::COUNTRY_CODES[$country]) : null;

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

        $countryCode = !empty(self::COUNTRY_CODES[$country]) ? strtolower(self::COUNTRY_CODES[$country]) : null;

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
                'check_status' => self::FILE_STATUS_CHECKING,
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


    public static function isNeedDeleteCacheKey($country, $cacheKey)
    {
        $cacheTimeApkMinutes = self::CACHE_TIME_LINK_APK_MINUTES;
        if (ApkBuilder::isCountryShortCacheTime($country)) {
            $cacheTimeApkMinutes = self::CACHE_TIME_LINK_APK_MINUTES_SHORT;
        }

        $keyInfo = \DB::table('amazon_files_built_key_caches')
            ->where('key', $cacheKey)
            ->first();

        if (!empty($keyInfo)) {

            $timeAddedKey = $keyInfo->created_at;

            if(!empty($keyInfo->updated_at)) {
                $timeAddedKey = $keyInfo->updated_at;
            }

            $start = Carbon::parse(Common::getCurrentVNTime());
            $end = Carbon::parse($timeAddedKey);

            $diffMinutes = $start->diffInMinutes($end);

            if ($diffMinutes >= $cacheTimeApkMinutes) {
                return true;
            }

            return false;
        }

        return true; //if key not exist in table => delete (default)
    }

    public static function deleteCacheKeyInTable($country, $cacheKey)
    {
        $keyInfo = \DB::table('amazon_files_built_key_caches')
            ->where('key', $cacheKey)
            ->first();

        $cacheTimeApkMinutes = self::CACHE_TIME_LINK_APK_MINUTES;
        if (ApkBuilder::isCountryShortCacheTime($country)) {
            $cacheTimeApkMinutes = self::CACHE_TIME_LINK_APK_MINUTES_SHORT;
        }

        if (!empty($keyInfo)) {

            $timeAddedKey = $keyInfo->created_at;

            if(!empty($keyInfo->updated_at)) {
                $timeAddedKey = $keyInfo->updated_at;
            }

            $start = Carbon::parse(Common::getCurrentVNTime());
            $end = Carbon::parse($timeAddedKey);

            $diffMinutes = $start->diffInMinutes($end);

            if ($diffMinutes >= $cacheTimeApkMinutes) {

                \DB::table('amazon_files_built_key_caches')
                    ->where('key', $cacheKey)
                    ->delete();

            }
        }



    }

}

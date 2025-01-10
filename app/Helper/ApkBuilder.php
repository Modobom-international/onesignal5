<?php


namespace App\Helper;

use Illuminate\Support\Facades\Notification;
use App\Jobs\BuildUpApkAmazonRemote;
use App\Jobs\DeleteDir;
use App\Jobs\UploadFileRemoteAmazon;
use App\Notifications\AmazonChecker;
use Illuminate\Http\File;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

class ApkBuilder
{

    const QUEUES_SUPPORT = [
        'amazon_build_file',
        'amazon_build_file_thailand',
        'amazon_build_file_thailand_v3',
//        'amazon_build_file_thailand_v4',
        'amazon_build_file_thailand_v5',
        'amazon_build_file_thailand_v6',
        'amazon_build_file_czech',
        'amazon_build_file_croatia',
        'amazon_build_file_serbia',
        'amazon_build_file_romania',
        'amazon_build_file_romania_v5',
        'amazon_build_file_bosnia',
        'amazon_build_file_slovenia',
        'amazon_build_file_switzerland',
        'amazon_build_file_denmark',
        'amazon_build_file_luxembourg',
        'amazon_build_file_malaysia',
        'amazon_build_file_single',
        'build_pool_apk_amazon',
        'amazon_upload_file',
        'amazon_check_link_status',
        'check_amazon_links_notify',
        'amazon_upload_file_thailand_v3',
//        'amazon_upload_file_thailand_v4',
        'amazon_upload_file_thailand_v5',
        'amazon_upload_file_thailand_google',
        'amazon_upload_file_thailand_facebook',
        'amazon_upload_file_thailand_tiktok',

        'amazon_upload_file_romania',
        'amazon_upload_file_romania_google',
        'amazon_upload_file_romania_facebook',
        'amazon_upload_file_romania_tiktok',
        'amazon_upload_file_romania_v5',

        'amazon_upload_file_croatia',
        'amazon_upload_file_croatia_google',
        'amazon_upload_file_croatia_facebook',
        'amazon_upload_file_croatia_tiktok',

        'amazon_upload_file_slovenia',
        'amazon_upload_file_slovenia_google',
        'amazon_upload_file_slovenia_facebook',
        'amazon_upload_file_slovenia_tiktok',

        'amazon_build_file_montenegro',
        'amazon_upload_file_montenegro',
        'amazon_upload_file_montenegro_google',
        'amazon_upload_file_montenegro_facebook',
        'amazon_upload_file_montenegro_tiktok',

        'amazon_upload_file_czech',
        'amazon_upload_file_czech_google',
        'amazon_upload_file_czech_facebook',
        'amazon_upload_file_czech_tiktok',

        'amazon_upload_file_switzerland',
        'amazon_upload_file_switzerland_google',
        'amazon_upload_file_switzerland_facebook',
        'amazon_upload_file_switzerland_tiktok',

        'amazon_upload_file_denmark',
        'amazon_upload_file_denmark',
        'amazon_upload_file_denmark',
        'amazon_upload_file_denmark',
        'amazon_upload_file_luxembourg',

        'amazon_upload_file_malaysia',
        'amazon_upload_file_malaysia_google',
        'amazon_upload_file_malaysia_facebook',
        'amazon_upload_file_malaysia_tiktok',

        'build_file_from_ui_thailand',
        'build_file_from_ui_romania',
        'build_file_from_ui_croatia',
        'build_file_from_ui_montenegro',
        'build_file_from_ui_slovenia',
        'build_file_from_ui_czech',
        'build_file_from_ui_switzerland',
        'build_file_from_ui_denmark',
        'build_file_from_ui_luxembourg',
        'build_file_from_ui_malaysia',

    ];

    const BUILD_VERSION_3 = '3';
    const BUILD_VERSION_4 = '4';
    const BUILD_VERSION_5 = '5';

    const VERSIONS_SUPPORT = [
        self::BUILD_VERSION_3,
        self::BUILD_VERSION_4,
        //self::BUILD_VERSION_5,
    ];

    const EU_COUNTRIES = [
        LinodeStorageObject::COUNTRY_ROMANIA,
        LinodeStorageObject::COUNTRY_CROATIA,
        LinodeStorageObject::COUNTRY_MACEDONIA,
        LinodeStorageObject::COUNTRY_CZECH,
        LinodeStorageObject::COUNTRY_SLOVENIA,
        LinodeStorageObject::COUNTRY_SLOVAKIA,
        LinodeStorageObject::COUNTRY_SWITZERLAND,
        LinodeStorageObject::COUNTRY_SERBIA,
        LinodeStorageObject::COUNTRY_MONTENEGRO,
        LinodeStorageObject::COUNTRY_BOSNIA,
        LinodeStorageObject::COUNTRY_EGYPT,
        LinodeStorageObject::COUNTRY_DENMARK,
        LinodeStorageObject::COUNTRY_LUXEMBOURG,
        //add more

    ];

    const COUNTRIES_SHORT_CACHE_TIME = [
        LinodeStorageObject::COUNTRY_ROMANIA,
        LinodeStorageObject::COUNTRY_CROATIA,
        LinodeStorageObject::COUNTRY_THAILAND,
        LinodeStorageObject::COUNTRY_CZECH,

    ];

    const DECOMPILE_COUNTRIES_SUPPORTED = [
        LinodeStorageObject::COUNTRY_ROMANIA,
        LinodeStorageObject::COUNTRY_CROATIA,
        LinodeStorageObject::COUNTRY_SLOVENIA,
        LinodeStorageObject::COUNTRY_MONTENEGRO,
        LinodeStorageObject::COUNTRY_THAILAND,
        LinodeStorageObject::COUNTRY_CZECH,
        LinodeStorageObject::COUNTRY_SWITZERLAND,
        LinodeStorageObject::COUNTRY_SLOVAKIA,
        LinodeStorageObject::COUNTRY_SERBIA,
        LinodeStorageObject::COUNTRY_MACEDONIA,
        LinodeStorageObject::COUNTRY_DENMARK,
        LinodeStorageObject::COUNTRY_LUXEMBOURG,
        LinodeStorageObject::COUNTRY_MALAYSIA,
        //add more
    ];

    const REMOTE_BUILD_COUNTRIES = [
        LinodeStorageObject::COUNTRY_THAILAND,
        LinodeStorageObject::COUNTRY_ROMANIA,
        LinodeStorageObject::COUNTRY_CROATIA,
        LinodeStorageObject::COUNTRY_MONTENEGRO,
        LinodeStorageObject::COUNTRY_CZECH,
        LinodeStorageObject::COUNTRY_SLOVENIA,
        LinodeStorageObject::COUNTRY_SWITZERLAND,
        LinodeStorageObject::COUNTRY_DENMARK,
        LinodeStorageObject::COUNTRY_LUXEMBOURG,
        LinodeStorageObject::COUNTRY_MALAYSIA,
        LinodeStorageObject::COUNTRY_VIETNAM,
    ];

    const AUTO_GENERATE_COUNT_NEW_LINKS = 2;


    public static function buildUpApkAmazonV5($sourceFilePath, $outputFilePath, $filenameShowUser, $bucketName, $country, $awsAccountIndex = 0, $itemId = null, $allowAutoRemove = 1)
    {
        //sleep random
        $rand = rand(0, 1);
        if ($rand > 0) {
            dump('=> sleep '.$rand.'s');
            sleep($rand);
        }

        //$this->sourcePathFile, $this->outputPathFile, $this->filenameShowUser,  $this->bucketName, $this->country, $this->itemId

        ///
        /// B1: build run command Version 1
        /// B2: run zip command cua Version 3
        /// B3: run build command cua Version 3
        ///
        ///
        /// source file path: /thailand/Thesim/sources/Thesim4_gg.apk
        /// output file path: /thailand/Thesim/files/0062670001672053986/Thesim4.apk
        ///
        ///
        ///
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V5');

        $outputFilePathV1 = self::getOutputFilePathV1($sourceFilePath);
        dump($outputFilePathV1);

        $sourceFilename = LinodeStorageObject::getFilenameByPath($sourceFilePath); //aceracer_fb.apk
        $newOutputFilename = LinodeStorageObject::generateOutputFilenameFromSource($sourceFilename); //Aceracer.apk
        $pathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($sourceFilePath); // /thailand/aceracer/sources

        //make `tmp` dir for apk
        LinodeStorageObject::makeTmpDirApk($sourceFilePath, 5); // /thailand/aceracer/tmp

        //$sourceFilePath = /thailand/minecraft/sources/minecraft_gg.apk
        //$outputFilePathV1 = /thailand/minecraft/tmp/123zxc_minecraft_gg.apk
        ///
        /// zipAndSignV3:
        ///     - zipalign:   /thailand/minecraft/tmp/123zxc_minecraft.apk  ===> /thailand/minecraft/tmp/zip_123zxc_minecraft.apk
        ///     - build v3:   /thailand/minecraft/tmp/zip_123zxc_minecraft.apk  ===> /thailand/minecraft/files/123zxc_minecraft.apk
        ///         -> and remove file: /thailand/minecraft/tmp/zip_123zxc_minecraft.apk


        $resultBuild = self::runBuildCommandV1($apkDir.$sourceFilePath, $apkDir.$outputFilePathV1);
        if ($resultBuild) {
            $resultZipBuild = self::zipAndSignV5($apkDir.$outputFilePathV1, $apkDir.$outputFilePath);

            if ($resultZipBuild) {
                //upload to amazon: dispatch to job
                $inputFileFullPath = $apkDir.$sourceFilePath;
                $outputFileFullPath = $apkDir.$outputFilePath;

                dump('input: '.$inputFileFullPath);
                dump('output: '.$outputFileFullPath);

                UploadFileRemoteAmazon::dispatch(
                    $apkDir,
                    $inputFileFullPath,
                    $outputFileFullPath,
                    $filenameShowUser,
                    $bucketName,
                    $country,
                    $awsAccountIndex,
                    $itemId,
                    null,
                    ApkBuilder::BUILD_VERSION_5,
                    $allowAutoRemove
                )->onQueue('amazon_upload_file');
            }
        }


    }

    public static function zipAndSignV5($inputFullFilePath, $outputFullFilePath)
    {
        //$inputFilePath => included base path
        //$outputFullFilePath => included base path


        /// zipAndSignV3:
        ///     - zipalign:   /thailand/minecraft/tmp/123zxc_minecraft_gg.apk  ===> /thailand/minecraft/tmp/zip_123zxc_minecraft_gg.apk
        ///     - build v3:   /thailand/minecraft/tmp/zip_123zxc_minecraft_gg.apk  ===> /thailand/minecraft/files/123zxc_minecraft.apk
        ///         -> and remove file: /thailand/minecraft/tmp/zip_123zxc_minecraft.apk

        ///
        /// zipalign -p 4 h1.apk h1_zip.apk
        //
        //java -jar apksigner.jar sign  --key key.pk8 --cert certificate.pem --in h1_zip.apk --out h1_out.apk

        $sourceFilename = LinodeStorageObject::getFilenameByPath($inputFullFilePath); //123zxc_minecraft_gg.apk
        $pathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($inputFullFilePath); // /thailand/minecraft/tmp

        $baseApkDir = env('AMAZON_APK_AUTO_BASE_DIR_V5');

        //mkdir output dir if not exist
        $outputPathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($outputFullFilePath); //include base path
        if (!is_dir($outputPathWithoutFilename)) {
            dump('=> mkdir '.$outputPathWithoutFilename);

            $tmpOutput = str_replace($baseApkDir, '', $outputPathWithoutFilename);

            \Storage::disk('local_apk_built_amazon_v5')->makeDirectory($tmpOutput);
            @mkdir($outputPathWithoutFilename, 0777, true);
        }

        $outputZipFilePath = $pathWithoutFilename.'/'.'zip_'.$sourceFilename; // /thailand/minecraft/tmp/zip_123zxc_minecraft_gg.apk

        $resultZip = self::runZipCommandV5($inputFullFilePath, $outputZipFilePath);

        if ($resultZip) {
            $resultBuild = self::runBuildCommandV5($outputZipFilePath, $outputFullFilePath);
            if ($resultBuild) {
                //delete tmp file & .idsig file & zip_ file


                $tmpIdsigFile = $outputFullFilePath.'.idsig';
                $tmpIdsigFile = str_replace($baseApkDir, '', $tmpIdsigFile);

                $zipFile = str_replace($baseApkDir, '', $outputZipFilePath);
                $inputFile = str_replace($baseApkDir, '', $inputFullFilePath);

                \Storage::disk('local_apk_built_amazon_v5')->delete($inputFile);
                \Storage::disk('local_apk_built_amazon_v5')->delete($tmpIdsigFile);
                \Storage::disk('local_apk_built_amazon_v5')->delete($zipFile);

            }

            return $resultBuild;
        }

        return false;
    }

    public static function runZipCommandV5($inputFilePath, $outputPath, $outputType = 'string')
    {
        //input: /mnt/c/auto-build/thailand/minecraft/facebook/sources/minecraft_fb.apk
        //output: /mnt/c/auto-build/thailand/minecraft/facebook/files/zip_123123_minecraft.apk

        $cmd = self::getZipCommandV3($inputFilePath, $outputPath, $outputType); //todo: v5 same as v3
        $process = new Process($cmd);
        $process->setTimeout(600);
        $process->run();

        dump('=> command zipalign V5: [result '.intval($process->isSuccessful()).'] '.$cmd);

        return $process->isSuccessful();
    }

    public static function runBuildCommandV5($fullInputPath, $fullOutputPath)
    {
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V5');

        $command = self::getAutoBuildCommandV5($fullInputPath, $fullOutputPath);
        $process = new Process($command, $apkDir);
        $process->setTimeout(600);
        $process->run();

        dump('=> command build V5: [result '.intval($process->isSuccessful()).'] '.$command);

        return $process->isSuccessful();
    }

    public static function getAutoBuildCommandV5($inputPath, $outputPath, $outputType = 'string')
    {
        $baseDir = env('AUTO_BUILD_COMMAND_BASE_DIR_V5');

        //$tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign --cert '.$baseDir.DIRECTORY_SEPARATOR.'certificate.pem  --key '.$baseDir.DIRECTORY_SEPARATOR.'key.pk8  --in '.$inputPath.'  --out '.$outputPath;

        $tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign  --ks '.$baseDir.DIRECTORY_SEPARATOR.'fancytexpro.keystore --ks-pass pass:fancytexpro  --v4-signing-enabled false --in "'.$inputPath.'"  --out "'.$outputPath.'"';

        $tmpResult = str_replace('  ', ' ', $tmpResult);

        return strtolower($outputType) == 'string' ? $tmpResult : explode(' ', $tmpResult);
    }

    /**
     * Build & Up files to Amazon - Version 3
     *
     * @param $sourceFilePath
     * @param $outputFilePath
     * @param $filenameShowUser
     * @param $bucketName
     * @param $country
     * @param int $awsAccountIndex
     * @param null $itemId
     * @param int $allowAutoRemove
     * @param bool $skipV1
     */
    public static function buildUpApkAmazonV3($sourceFilePath, $outputFilePath, $filenameShowUser, $bucketName, $country, $awsAccountIndex = 0, $itemId = null, $allowAutoRemove = 1, $skipV1 = false)
    {
        //sleep random
        $rand = rand(0, 1);
        if ($rand > 0) {
            //dump('=> sleep '.$rand.'s');
            //sleep($rand);
        }

        //$this->sourcePathFile, $this->outputPathFile, $this->filenameShowUser,  $this->bucketName, $this->country, $this->itemId

        ///
        /// B1: build run command Version 1
        /// B2: run zip command cua Version 3
        /// B3: run build command cua Version 3
        ///
        ///
        /// source file path: /thailand/Thesim/sources/Thesim4_gg.apk
        /// output file path: /thailand/Thesim/files/0062670001672053986/Thesim4.apk
        ///
        ///
        ///
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V3');

        $outputFilePathV1 = self::getOutputFilePathV1($sourceFilePath);
        dump($outputFilePathV1);

        $sourceFilename = LinodeStorageObject::getFilenameByPath($sourceFilePath); //aceracer_fb.apk
        $newOutputFilename = LinodeStorageObject::generateOutputFilenameFromSource($sourceFilename); //Aceracer.apk
        $pathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($sourceFilePath); // /thailand/aceracer/sources

        LinodeStorageObject::makeTmpDirApk($sourceFilePath, 3); // /thailand/aceracer/tmp

        //$sourceFilePath = /thailand/minecraft/sources/minecraft_gg.apk
        //$outputFilePathV1 = /thailand/minecraft/tmp/123zxc_minecraft_gg.apk
        ///
        /// zipAndSignV3:
        ///     - zipalign:   /thailand/minecraft/tmp/123zxc_minecraft.apk  ===> /thailand/minecraft/tmp/zip_123zxc_minecraft.apk
        ///     - build v3:   /thailand/minecraft/tmp/zip_123zxc_minecraft.apk  ===> /thailand/minecraft/files/123zxc_minecraft.apk
        ///         -> and remove file: /thailand/minecraft/tmp/zip_123zxc_minecraft.apk


        $resultBuildV1 = $skipV1 ? true : self::runBuildCommandV1($apkDir.$sourceFilePath, $apkDir.$outputFilePathV1);

        if ($resultBuildV1) {
            $fullSourceFileV3 = $skipV1 ? $apkDir.$sourceFilePath : $apkDir.$outputFilePathV1;

            $resultZipBuildV3First = self::zipAndSignV3($fullSourceFileV3, $apkDir.$outputFilePath); //run build 1

            if ($resultZipBuildV3First) {
                //upload to amazon: dispatch to job
                $inputFileFullPath = $apkDir.$sourceFilePath;
                $outputFileFullPath = $apkDir.$outputFilePath;

                dump('input: '.$inputFileFullPath);
                dump('output: '.$outputFileFullPath);

                self::uploadFileRemoteAmazon(self::BUILD_VERSION_3, $country, $apkDir, $inputFileFullPath, $outputFileFullPath, $filenameShowUser, $bucketName, $awsAccountIndex, $itemId, null, $allowAutoRemove);

            } //end if

            //todo: logging

        } //end if

    }


    public static function getAutoBuildCommandV3($inputPath, $outputPath, $outputType = 'string', $buildAgain = false)
    {
        $baseDir = env('AUTO_BUILD_COMMAND_BASE_DIR_V3');

        //key thailand
        //$tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign --cert '.$baseDir.DIRECTORY_SEPARATOR.'certificate.pem  --key '.$baseDir.DIRECTORY_SEPARATOR.'key.pk8  --in '.$inputPath.'  --out '.$outputPath;

        //use key of EU
        //$tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign --cert '.$baseDir.DIRECTORY_SEPARATOR.'certv4.pem  --key '.$baseDir.DIRECTORY_SEPARATOR.'keyv4.pk8  --in '.$inputPath.'  --out '.$outputPath;

        //change key 22/5/2024
        $tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign --cert '.$baseDir.DIRECTORY_SEPARATOR.'apkeasytool.pem  --key '.$baseDir.DIRECTORY_SEPARATOR.'apkeasytool.pk8  --in '.$inputPath.'  --out '.$outputPath;


        //todo: handle command v3 for EU countries
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V3'); // /root/build_apk_files_amazon
        $pathRelative = str_replace($apkDir, '', $outputPath); //path relative without base dir. Ex: /thailand/lulubox/files/0094544001684848862/Lulubox.apk

        if (self::isEuCountryApk($pathRelative)) {
            //$tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign --cert '.$baseDir.DIRECTORY_SEPARATOR.'certificate_eu.pem  --key '.$baseDir.DIRECTORY_SEPARATOR.'key_eu.pk8  --in '.$inputPath.'  --out '.$outputPath;
            //$tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign --cert '.$baseDir.DIRECTORY_SEPARATOR.'certv4.pem  --key '.$baseDir.DIRECTORY_SEPARATOR.'keyv4.pk8  --in '.$inputPath.'  --out '.$outputPath;

            //change key 14/6/2024
            //$tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign --cert '.$baseDir.DIRECTORY_SEPARATOR.'certv6.pem  --key '.$baseDir.DIRECTORY_SEPARATOR.'keyv6.pk8  --in '.$inputPath.'  --out '.$outputPath;

            //change key 16/6/2024 - tmp off
            ///verity.pk8
            //verity.x509.pem
            //$tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign --cert '.$baseDir.DIRECTORY_SEPARATOR.'verity.x509.pem  --key '.$baseDir.DIRECTORY_SEPARATOR.'verity.pk8  --in '.$inputPath.'  --out '.$outputPath;


            //change key 22/5/2024
            //$tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign --cert '.$baseDir.DIRECTORY_SEPARATOR.'apkeasytool.pem  --key '.$baseDir.DIRECTORY_SEPARATOR.'apkeasytool.pk8  --in '.$inputPath.'  --out '.$outputPath;


            //test use command of v5
//            $tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign  --ks '.$baseDir.DIRECTORY_SEPARATOR.'v5.keystore --ks-pass pass:android  --v4-signing-enabled false --in "'.$inputPath.'"  --out "'.$outputPath.'"';
//
//            if ($buildAgain) { //use key & command of v5
//                $baseDir = env('AUTO_BUILD_COMMAND_BASE_DIR_V5');
//                //$tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign  --ks '.$baseDir.DIRECTORY_SEPARATOR.'fancytexpro.keystore --ks-pass pass:fancytexpro  --v4-signing-enabled false --in "'.$inputPath.'"  --out "'.$outputPath.'"';
//                $tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign  --ks '.$baseDir.DIRECTORY_SEPARATOR.'v5.keystore --ks-pass pass:android  --v4-signing-enabled false --in "'.$inputPath.'"  --out "'.$outputPath.'"';
//
//                //$tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apksigner.jar sign --cert '.$baseDir.DIRECTORY_SEPARATOR.'certv7.pem  --key '.$baseDir.DIRECTORY_SEPARATOR.'keyv7.pk8  --in '.$inputPath.'  --out '.$outputPath; //command & key of v3
//            }

        }

        $tmpResult = str_replace('  ', ' ', $tmpResult);

        return strtolower($outputType) == 'string' ? $tmpResult : explode(' ', $tmpResult);
    }

    public static function getAutoBuildCommandV1($inputFullPath, $outputFullPath, $outputType = 'string')
    {
        $baseDir = env('AUTO_BUILD_COMMAND_BASE_DIR');
        $tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'signapk.jar  '.$baseDir.DIRECTORY_SEPARATOR.'certificate.pem  '.$baseDir.DIRECTORY_SEPARATOR.'key.pk8  '.$inputFullPath.'  '.$outputFullPath;

        $tmpResult = str_replace('  ', ' ', $tmpResult);

        return strtolower($outputType) == 'string' ? $tmpResult : explode(' ', $tmpResult);
    }

    public static function runZipCommandV3($inputFilePath, $outputPath, $outputType = 'string')
    {
        //input: /mnt/c/auto-build/thailand/minecraft/facebook/sources/minecraft_fb.apk
        //output: /mnt/c/auto-build/thailand/minecraft/facebook/files/zip_123123_minecraft.apk

        $cmd = self::getZipCommandV3($inputFilePath, $outputPath, $outputType);
        $process = new Process($cmd);
        $process->setTimeout(600);
        $process->run();

        dump('=> command zipalign V3: [result '.intval($process->isSuccessful()).'] '.$cmd);

        return $process->isSuccessful();
    }

    public static function runBuildCommandV3($fullInputPath, $fullOutputPath, $buildAgain = false)
    {
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR');

        $command = self::getAutoBuildCommandV3($fullInputPath, $fullOutputPath, 'string', $buildAgain);
        $process = new Process($command, $apkDir);
        $process->setTimeout(600);
        $process->run();

        dump('=> command build V3: [result '.intval($process->isSuccessful()).'] '.$command);

        return $process->isSuccessful();
    }

    public static function runBuildCommandV1($fullInputPath, $fullOutputPath)
    {
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR');

        $command = self::getAutoBuildCommandV1($fullInputPath, $fullOutputPath);
        $process = new Process($command, $apkDir);
        $process->setTimeout(600);
        $process->run();

        dump('-> command build V1: [result '.intval($process->isSuccessful()).'] '.$command);

        return $process->isSuccessful();
    }

    public static function getZipCommandV3($inputPath, $outputPath, $outputType = 'string')
    {
        $zipBaseDir = env('ZIPALIGN_COMMAND_BASE_DIR');
        $cmd = env('ZIPALIGN_EXECUTE_COMMAND');

        //$inputPath = str_replace($zipBaseDir . '/', '', $inputPath);
        //$outputPath = str_replace($zipBaseDir . '/', '', $outputPath);

        $cmd = str_replace('@@input@@', $inputPath, $cmd);
        $cmd = str_replace('@@output@@', $outputPath, $cmd);

        $cmd = 'cd '.$zipBaseDir.' && '.$cmd;
        $tmpResult = str_replace('  ', ' ', $cmd);

        //Ex: cd /mnt/c/auto-build && zipalign.exe -f -p 4 input.apk output.apk

        return strtolower($outputType) == 'string' ? $tmpResult : explode(' ', $tmpResult);
    }

    public static function zipAndSignV3($inputFullFilePath, $outputFullFilePath, $buildAgain = false)
    {
        //$inputFilePath => included base path
        //$outputFullFilePath => included base path


        /// zipAndSignV3:
        ///     - zipalign:   /thailand/minecraft/tmp/123zxc_minecraft_gg.apk  ===> /thailand/minecraft/tmp/zip_123zxc_minecraft_gg.apk
        ///     - build v3:   /thailand/minecraft/tmp/zip_123zxc_minecraft_gg.apk  ===> /thailand/minecraft/files/123zxc_minecraft.apk
        ///         -> and remove file: /thailand/minecraft/tmp/zip_123zxc_minecraft.apk

        ///
        /// zipalign -p 4 h1.apk h1_zip.apk
        //
        //java -jar apksigner.jar sign  --key key.pk8 --cert certificate.pem --in h1_zip.apk --out h1_out.apk

        $sourceFilename = LinodeStorageObject::getFilenameByPath($inputFullFilePath); //123zxc_minecraft_gg.apk
        $pathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($inputFullFilePath); // /thailand/minecraft/tmp

        $baseApkDir = env('AMAZON_APK_AUTO_BASE_DIR');

        //mkdir output dir if not exist
        $outputPathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($outputFullFilePath); //include base path
        if (!is_dir($outputPathWithoutFilename)) {
            dump('=> mkdir '.$outputPathWithoutFilename);

            $tmpOutput = str_replace($baseApkDir, '', $outputPathWithoutFilename);

            \Storage::disk('local_apk_built_amazon')->makeDirectory($tmpOutput);
            @mkdir($outputPathWithoutFilename, 0777, true);
        }

        $outputZipFilePath = $pathWithoutFilename.'/'.'zip_'.$sourceFilename; // /thailand/minecraft/tmp/zip_123zxc_minecraft_gg.apk

        $resultZip = self::runZipCommandV3($inputFullFilePath, $outputZipFilePath);

        if ($resultZip) {
            $resultBuild = self::runBuildCommandV3($outputZipFilePath, $outputFullFilePath, $buildAgain);
            if ($resultBuild) {
                //delete tmp file & .idsig file & zip_ file


                $tmpIdsigFile = $outputFullFilePath.'.idsig';
                $tmpIdsigFile = str_replace($baseApkDir, '', $tmpIdsigFile);

                $zipFile = str_replace($baseApkDir, '', $outputZipFilePath);
                $inputFile = str_replace($baseApkDir, '', $inputFullFilePath);

                \Storage::disk('local_apk_built_amazon')->delete($inputFile);
                \Storage::disk('local_apk_built_amazon')->delete($tmpIdsigFile);
                \Storage::disk('local_apk_built_amazon')->delete($zipFile);

            }

            return $resultBuild;
        }

        return false;
    }

    public static function getOutputFilePathV1($sourceFilePath)
    {
        //source file path: /thailand/minecraft/sources/minecraft_gg.apk
        //output file path v1: /thailand/minecraft/tmp/123zxc_minecraft_gg.apk

        $sourceFilename = LinodeStorageObject::getFilenameByPath($sourceFilePath); //minecraft_gg.apk
        $pathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($sourceFilePath); // /thailand/minecraft/sources

        $outputPath = str_replace('sources', 'tmp', $pathWithoutFilename); // /thailand/minecraft/tmp
        $baseApkDir = env('AMAZON_APK_AUTO_BASE_DIR');

        dump(is_dir($baseApkDir.$outputPath));
        if (!is_dir($baseApkDir.$outputPath)) {
            @mkdir($baseApkDir.$outputPath, 0777, true);
        }

        $randomPrefixDir = 'a'.self::getUniqueStr();

        return $outputPath.'/'.$randomPrefixDir.'_'.$sourceFilename;
    }

    public static function getQueueBuildAmazonCountry($country, $version = 3)
    {
        $default = 'amazon_build_file';

        if (in_array($default.'_'.strtolower($country), self::QUEUES_SUPPORT)) {
            if (strtolower($country) == LinodeStorageObject::COUNTRY_THAILAND) {
                return $default.'_'.strtolower($country).'_v'.$version;
            }

            if (strtolower($country) == LinodeStorageObject::COUNTRY_ROMANIA && $version == 5) {
                return $default.'_romania_v5';
            }

            return $default.'_'.strtolower($country);
        }

        return $default;
    }

    public static function buildUpApkAmazonV4($sourceFilePath, $outputFilePath, $filenameShowUser, $bucketName, $country, $awsAccountIndex = 0, $itemId = null, $allowAutoRemove = 1)
    {
        //sleep random
        $rand = rand(0, 1);
        if ($rand > 0) {
            dump('=> sleep '.$rand.'s');
            sleep($rand);
        }

        //$this->sourcePathFile, $this->outputPathFile, $this->filenameShowUser,  $this->bucketName, $this->country, $this->itemId

        ///
        /// B1: build run command Version 1
        /// B2: run zip command cua Version 3
        /// B3: run build command cua Version 3
        ///
        ///
        /// source file path: /thailand/Thesim/sources/Thesim4_gg.apk
        /// output file path: /thailand/Thesim/files/0062670001672053986/Thesim4.apk
        ///
        ///
        ///
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V4');

        $outputFilePathV1 = self::getOutputFilePathV4($sourceFilePath);
        dump($outputFilePathV1);

        $sourceFilename = LinodeStorageObject::getFilenameByPath($sourceFilePath); //aceracer_fb.apk
        $newOutputFilename = LinodeStorageObject::generateOutputFilenameFromSource($sourceFilename); //Aceracer.apk
        $pathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($sourceFilePath); // /thailand/aceracer/sources

        LinodeStorageObject::makeTmpDirApk($sourceFilePath, 4); // /thailand/aceracer/tmp

        //$sourceFilePath = /thailand/minecraft/sources/minecraft_gg.apk
        //$outputFilePathV1 = /thailand/minecraft/tmp/123zxc_minecraft_gg.apk
        ///
        /// zipAndSignV3:
        ///     - zipalign:   /thailand/minecraft/tmp/123zxc_minecraft.apk  ===> /thailand/minecraft/tmp/zip_123zxc_minecraft.apk
        ///     - build v3:   /thailand/minecraft/tmp/zip_123zxc_minecraft.apk  ===> /thailand/minecraft/files/123zxc_minecraft.apk
        ///         -> and remove file: /thailand/minecraft/tmp/zip_123zxc_minecraft.apk


        $resultBuild = self::runBuildCommandV4($apkDir.$sourceFilePath, $apkDir.$outputFilePath);
        if ($resultBuild) {

            //upload to amazon: dispatch to job
            $inputFileFullPath = $apkDir.$sourceFilePath;
            $outputFileFullPath = $apkDir.$outputFilePath;

            dump('input: '.$inputFileFullPath);
            dump('output: '.$outputFileFullPath);

            self::uploadFileRemoteAmazon(self::BUILD_VERSION_4, $country, $apkDir, $inputFileFullPath, $outputFileFullPath, $filenameShowUser, $bucketName, $awsAccountIndex, $itemId, null, $allowAutoRemove);

        }


    }

    public static function getOutputFilePathV4($sourceFilePath)
    {
        //source file path: /thailand/minecraft/sources/minecraft_gg.apk
        //output file path v1: /thailand/minecraft/tmp/123zxc_minecraft_gg.apk

        $sourceFilename = LinodeStorageObject::getFilenameByPath($sourceFilePath); //minecraft_gg.apk
        $pathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($sourceFilePath); // /thailand/minecraft/sources

        $outputPath = str_replace('sources', 'tmp', $pathWithoutFilename); // /thailand/minecraft/tmp
        $baseApkDir = env('AMAZON_APK_AUTO_BASE_DIR_V4');

        dump(is_dir($baseApkDir.$outputPath));
        if (!is_dir($baseApkDir.$outputPath)) {
            @mkdir($baseApkDir.$outputPath, 0777, true);
        }

        $randomPrefixDir = self::getUniqueStr();

        return $outputPath.'/'.$randomPrefixDir.'_'.$sourceFilename;
    }

    public static function runBuildCommandV4($fullInputPath, $fullOutputPath)
    {
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V4');

        $command = self::getAutoBuildCommandV4($fullInputPath, $fullOutputPath);
        $process = new Process($command, $apkDir);
        $process->setTimeout(600);
        $process->run();

        dump('-> command build V4: [result '.intval($process->isSuccessful()).'] '.$command);

        return $process->isSuccessful();
    }

    public static function getAutoBuildCommandV4($inputFullPath, $outputFullPath, $outputType = 'string')
    {
        $baseCmdDir = env('AUTO_BUILD_COMMAND_BASE_DIR_V4');
        $tmpResult = 'java -jar '.$baseCmdDir.DIRECTORY_SEPARATOR.'signv4.jar  '.$baseCmdDir.DIRECTORY_SEPARATOR.'certv4.pem  '.$baseCmdDir.DIRECTORY_SEPARATOR.'keyv4.pk8  '.$inputFullPath.'  '.$outputFullPath;

        $tmpResult = str_replace('  ', ' ', $tmpResult);

        return strtolower($outputType) == 'string' ? $tmpResult : explode(' ', $tmpResult);
    }

    /**
     * Check if version given is supported
     *
     * @param $version
     * @return bool
     */
    public static function isValidVersion($version)
    {
        return in_array($version, self::VERSIONS_SUPPORT);
    }

    public static function isEuCountryApk($inputFilePath)
    {
        if (empty($inputFilePath)) {
            return false;
        }

        $country = strtolower(LinodeStorageObject::detectCountryByDir($inputFilePath)); //todo: detect country dir (without slash)

        return in_array($country, self::EU_COUNTRIES);
    }

    public static function getUniqueStr($length = 8)
    {
        return \Str::random($length);

        //return 'apks'.Common::getUniqueStr();
    }

    public static function decompileAndCompile($inputFullPath, $outputFullPath, $addSecretDir = true, $version = self::BUILD_VERSION_3)
    {
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR');

        $tmpDirDecompile = self::getOutputTmpPathDecompile($inputFullPath);

        $command = self::getDecompileCommand($inputFullPath, $tmpDirDecompile);
        $process = new Process($command);
        $process->setTimeout(600); //10 minutes
        $process->run();

        dump('-> command decompile: [result '.intval($process->isSuccessful()).'] '.$command);

        $packageId = null;

        if ($process->isSuccessful()) {
            //todo: rename dir $tmpDirDecompile/smali/a ==> $tmpDirDecompile/smali/axxxx
            $dirRandom = self::getUniqueStr();

            //remove test dir
            $dirTest = $tmpDirDecompile.'/smali/test';
            if (is_dir($dirTest)) {
                Common::deleteDirectory($dirTest);
            }

            $dirTest2 = $tmpDirDecompile.'/smali/Test';
            if (is_dir($dirTest2)) {
                Common::deleteDirectory($dirTest2);
            }


            //check country
            $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V'.$version);
            $inputPath = str_replace($apkDir, '', $inputFullPath); //input path without base dir
            $country = LinodeStorageObject::detectCountryByDir($inputPath);

            //if ($country != LinodeStorageObject::COUNTRY_CZECH) {

            //only use if country != Czech
            $secretDir = env('DECOMPILE_SECRET_DIR'); // /root/scripts/build_apk/secret/lala
//            if ($addSecretDir) {
//                if (!empty($secretDir) && is_dir($secretDir)) {
//                    $filesystem = new Filesystem();
//
//                    $targetDir = $tmpDirDecompile.'/smali/'.ApkBuilder::getUniqueStr();
//
//                    @mkdir($targetDir);
//
//                    $filesystem->mirror($secretDir, $targetDir); //copy
//
//                    //edit file main
//                    //$mainFile = 'ActivityMainBinding.smali'; //todo: get from config
//                    $mainFile = 'MainActivityFm.smali'; //todo: get from config
//
//                    $mainFileFullPath = $targetDir.'/'.$mainFile;
//
//                    //change content of main file in secret dir
//                    self::refreshMainFileSecret($mainFileFullPath);
//
//                }
//            }

            //todo: change package info in file: AndroidManifest.xml & apktool.yml
            if (env('ENABLE_AUTO_CHANGE_PACKAGE_ID', false)) {
                $resultChangePackageInfo = self::changePackageInfo($tmpDirDecompile);

                $packageId = $resultChangePackageInfo['package_id'] ?? null;
            }

            //}
            //end check czech

            $command2 = self::getCompileCommand($tmpDirDecompile, $outputFullPath);
            $process2 = new Process($command2);
            $process2->setTimeout(600); //10 minutes
            $process2->run();

            dump('-> command compile: [result '.intval($process2->isSuccessful()).'] '.$command2);

            //remove tmp dir if success
            if ($process2->isSuccessful()) {
                dump('=> deleting tmp dir compile '.$tmpDirDecompile);
                DeleteDir::dispatch($tmpDirDecompile)->onQueue('delete_dir');

            }

            //notify when compile error
            if (!$process2->isSuccessful()) {
                $output = $process2->getOutput().$process2->getErrorOutput();

                //input: /root/build_apk_files_amazon/slovenia/happymod/tmp/decompile_YyYc4g6d_Happymod_gg
                //output: /root/build_apk_files_amazon/slovenia/happymod/tmp/compile_i0qEnLJN_Happymod_gg.apk

                //check country
                $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V'.$version);
                $inputPath = str_replace($apkDir, '', $inputFullPath); //input path without base dir
                $country = ucwords(LinodeStorageObject::detectCountryByDir($inputPath));
                $platform = LinodeStorageObject::getFilePlatform($inputPath);

                $parts = explode('/', $inputPath);
                $appId = $parts[2];

                $details = [
                    'message' => sprintf("Compile error! \n\n- Country: %s\n- App id: %s\n- Platform: %s\n- Version: %s\n- Command compile: %s\n\n=> Error log: %s", $country, $appId, $platform, $version, $command2, $output),
                ];

                \Notification::route('telegram', env('TELEGRAM_AMAZON_CHANNEL_ID'))->notify(new AmazonChecker($details));
            }

            return [
                'is_success' => $process2->isSuccessful(),
                'package_id' => $packageId,
            ];

        }

        return [
          'is_success' => $process->isSuccessful(),
          'package_id' => $packageId,
        ];

    }

    public static function getDecompileCommand($inputFullPath, $outputFullPath, $outputType = 'string')
    {
        $baseDir = env('AUTO_BUILD_COMMAND_BASE_DIR');

        ///
        /// java  -jar "apktool_2.6.1.jar" d -f --only-main-classes "Carxstreet_doc_hai.apk" -o "tmp/Carxstreet"
        ///

        $tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apktool_2.6.1.jar d -f --only-main-classes '.$inputFullPath.'  -o '.$outputFullPath;

        $tmpResult = str_replace('  ', ' ', $tmpResult);

        return strtolower($outputType) == 'string' ? $tmpResult : explode(' ', $tmpResult);
    }

    public static function getCompileCommand($fullInputDir, $fullOutputFileCompile, $outputType = 'string')
    {

        $baseDir = env('AUTO_BUILD_COMMAND_BASE_DIR');

        ///
        /// java -jar "/mnt/d/auto_build/decompile_compile/apktool_2.6.1.jar" b -f --use-aapt2 "/mnt/d/auto_build/tmp/Carxstreet" -o "/mnt/d/auto_build/Carxstreet-compiled.apk"
        /// --v4-signing-enabled false --out

        $tmpResult = 'java -jar '.$baseDir.DIRECTORY_SEPARATOR.'apktool_2.6.1.jar b -f --use-aapt2  -o "'.$fullOutputFileCompile.'" "'.$fullInputDir.'" ';

        $tmpResult = str_replace('  ', ' ', $tmpResult);

        return strtolower($outputType) == 'string' ? $tmpResult : explode(' ', $tmpResult);
    }

    /**
     * Output file compile
     *
     * @param $sourceFullFilePath
     * @return string
     */
    public static function getOutputFilePathCompile($sourceFullFilePath)
    {
        //source file path: /thailand/minecraft/sources/minecraft_gg.apk
        //output file path compile: /thailand/minecraft/tmp/compile_123456_minecraft_gg.apk

        $sourceFilename = LinodeStorageObject::getFilenameByPath($sourceFullFilePath); //minecraft_gg.apk
        $pathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($sourceFullFilePath); // /thailand/minecraft/sources

        $outputPath = str_replace('sources', 'tmp', $pathWithoutFilename); // /thailand/minecraft/tmp

        dump(is_dir($outputPath));
        if (!is_dir($outputPath)) {
            @mkdir($outputPath, 0777, true);
        }

        $randomPrefixDir = self::getUniqueStr();

        return $outputPath.'/compile_'.$randomPrefixDir.'_'.$sourceFilename;
    }

    /**
     * Tmp path output decompile
     *
     * @param $sourceFullFilePath
     * @param bool $useTmpDir
     * @param bool $randomPrefix
     * @return string
     */
    public static function getOutputTmpPathDecompile($sourceFullFilePath, $useTmpDir = true, $randomPrefix = true)
    {
        //source file path: /thailand/minecraft/sources/minecraft_gg.apk
        //output file path compile: /thailand/minecraft/tmp/decompile_123456_minecraft_gg

        $sourceFilename = LinodeStorageObject::getFilenameByPath($sourceFullFilePath); //minecraft_gg.apk
        $pathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($sourceFullFilePath); // /thailand/minecraft/sources

        $outputPath = $useTmpDir ? str_replace('sources', 'tmp', $pathWithoutFilename) : $pathWithoutFilename; // /thailand/minecraft/tmp

        dump(is_dir($outputPath));
        if (!is_dir($outputPath)) {
            @mkdir($outputPath, 0777, true);
        }

        $randomPrefixDir = $randomPrefix ? '_'.self::getUniqueStr() : null;

        $dir = $outputPath.'/decompile'.$randomPrefixDir.'_'.$sourceFilename;
        $dir = str_replace('.apk', '', $dir);
        $dir = str_replace('.APK', '', $dir);

        return $dir;
    }

    /**
     * @param $version
     * @param $country
     * @param $apkDir
     * @param $inputFileFullPath
     * @param $outputFileFullPath
     * @param $filenameShowUser
     * @param $bucketName
     * @param $awsAccountIndex
     * @param null $itemId
     * @param null $poolItemId
     * @param int $allowAutoRemove
     *
     */
    public static function uploadFileRemoteAmazon($version, $country, $apkDir, $inputFileFullPath, $outputFileFullPath, $filenameShowUser, $bucketName, $awsAccountIndex, $itemId = null, $poolItemId = null, $allowAutoRemove = 1)
    {
        /*
        if (in_array($country, self::EU_COUNTRIES) && $version == ApkBuilder::BUILD_VERSION_3) {

            //build v3 again (for countries EU & V3)
            $inputFullPart2 = $outputFileFullPath;
            $outputFullPart2 = self::getOutputFilePathV1($inputFullPart2);

            $buildAgain = true;
            dump(sprintf(Common::getCurrentVNTime().' [build v3 again] ==> Build v3 again for EU countries (item Id: %s); old input: %s, old output: %s; new input: %s, new output: %s', $itemId, $inputFileFullPath, $outputFileFullPath, $inputFullPart2, $outputFullPart2));

            $resultZipBuildV3Second = self::zipAndSignV3($inputFullPart2, $outputFullPart2, $buildAgain); //run build 2

            if ($resultZipBuildV3Second) {

                //move new file to old file (overwrite)
                $filesystem = new Filesystem();

                try {
                    $filesystem->copy($outputFullPart2, $outputFileFullPath, true);

                } catch (\Exception $ex) {
                    dump(Common::getCurrentVNTime().' ==> [build v3 again] '.$ex->getMessage());
                    dump(Common::getCurrentVNTime().sprintf(' [build v3 again] Error while copy output file %s ==> %s', $outputFullPart2, $outputFileFullPath));

                }

                dump(Common::getCurrentVNTime().sprintf(' [build v3 again] copy output file %s ==> %s', $outputFullPart2, $outputFileFullPath));

            }

        }
        */


        $queue = 'amazon_upload_file';
        $platform = AmazonS3::getFilePlatform($inputFileFullPath);
        //todo: use new queue with platform

        if ($country == LinodeStorageObject::COUNTRY_THAILAND) {
            $queue = 'amazon_upload_file_thailand_v'.$version;
        }

        if ($country == LinodeStorageObject::COUNTRY_ROMANIA) {
            $queue = 'amazon_upload_file_romania';
        }

        if ($country == LinodeStorageObject::COUNTRY_CROATIA) {
            $queue = 'amazon_upload_file_croatia';
        }

        if ($country == LinodeStorageObject::COUNTRY_SLOVENIA) {
            $queue = 'amazon_upload_file_slovenia';
        }

        UploadFileRemoteAmazon::dispatch(
            $apkDir,
            $inputFileFullPath,
            $outputFileFullPath,
            $filenameShowUser,
            $bucketName,
            $country,
            $awsAccountIndex,
            $itemId,
            $poolItemId,
            $version,
            $allowAutoRemove
        )->onQueue($queue);

    }

    /**
     * Test compile & build v3 for debug
     *
     * @param $fullPathInputFile
     * @param null $fullPathOutputFile
     * @param bool $addSecretDir
     * @return bool
     */
    public static function testCompileAndBuildFullV3($fullPathInputFile, $fullPathOutputFile, $addSecretDir = true)
    {
        //decompile & compile source apk
        $version = 3;
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V'.$version);

        $outputFullFilePathCompile = ApkBuilder::getOutputFilePathCompile($fullPathInputFile);
        $resultCompile = ApkBuilder::decompileAndCompile($fullPathInputFile, $outputFullFilePathCompile, $addSecretDir);

        dump('result decompile & compile: '.$resultCompile['is_success']);

        if (!$resultCompile['is_success']) {
            dump(sprintf('=> Error while decompile & compile file %s', $fullPathInputFile));

            return false;
        }

        //todo: rsync file {$outputFullFilePathCompile} from clone server ==> main server

        $outputFilePathCompile = str_replace($apkDir, '', $outputFullFilePathCompile); //without base path
        $newFilename = LinodeStorageObject::getFilenameByPath($outputFullFilePathCompile);

        $pathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($outputFilePathCompile); // without filename (only dir)

        //todo: - decompile & compile done => call job build to `main server`

        //$outputFilePath = '/mnt/c/Users/Admin/Desktop/ducho_test_build/ducho_output_'.Common::getUniqueStr().'.apk';
        $resultZipBuild = self::zipAndSignV3($outputFullFilePathCompile, $fullPathOutputFile);

        dump($fullPathOutputFile);
        dump('result build v3: '.$resultZipBuild);

    }

    public static function isCountrySupportedDecompile($country)
    {
        return in_array(strtolower(trim($country)), self::DECOMPILE_COUNTRIES_SUPPORTED);
    }

    public static function getQueueDecompileSingle($country, $version = ApkBuilder::BUILD_VERSION_3)
    {
        return 'decompile_'.strtolower(trim($country)).'_single';
    }

    public static function decompile($inputFullPath, $dirDecompileOutput, $version = self::BUILD_VERSION_3)
    {
        //$tmpDirDecompile = self::getOutputTmpPathDecompile($inputFullPath);

        $command = self::getDecompileCommand($inputFullPath, $dirDecompileOutput);
        $process = new Process($command);
        $process->setTimeout(600); //10 minutes
        $process->run();

        dump('-> command decompile: [result '.intval($process->isSuccessful()).'] '.$command);

        if ($process->isSuccessful()) {
            //delete `/smali/test` dir
            $dirTest = $dirDecompileOutput.'/smali/test';
            if (is_dir($dirTest)) {
                Common::deleteDirectory($dirTest);
            }
        }

        //notify telegram if decompile error
        if (!$process->isSuccessful()) {
            $output = $process->getOutput().$process->getErrorOutput();

            //input: /root/build_apk_files_amazon/slovenia/happymod/tmp/decompile_YyYc4g6d_Happymod_gg
            //output: /root/build_apk_files_amazon/slovenia/happymod/tmp/compile_i0qEnLJN_Happymod_gg.apk

            //check country
            $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V'.$version);
            $inputPath = str_replace($apkDir, '', $inputFullPath); //input path without base dir
            $country = ucwords(LinodeStorageObject::detectCountryByDir($inputPath));
            $platform = LinodeStorageObject::getFilePlatform($inputPath);

            $parts = explode('/', $inputPath);
            $appId = $parts[2];

            $details = [
                'message' => sprintf("Decompile error! \n\n- Country: %s\n- App id: %s\n- Platform: %s\n- Version: %s\n- Command decompile: %s\n\n=> Error log: %s", $country, $appId, $platform, $version, $command, $output),
            ];

            \Notification::route('telegram', env('TELEGRAM_AMAZON_CHANNEL_ID'))->notify(new AmazonChecker($details));

        }

        return $process->isSuccessful();
    }

    /**
     * Compile apk (from decompile dir)
     *
     * @param $fullDecompileDir
     * @param $outputFullPath
     * @param bool $deleteSourceDir
     * @param string $version
     * @return array
     */
    public static function compile($fullDecompileDir, $outputFullPath, $deleteSourceDir = false, $version = self::BUILD_VERSION_3)
    {

        //todo: rename dir $tmpDirDecompile/smali/a ==> $tmpDirDecompile/smali/axxxx
        $dirRandom = self::getUniqueStr();

        //remove test dir
        $dirTest = $fullDecompileDir.'/smali/test';
        if (is_dir($dirTest)) {
            Common::deleteDirectory($dirTest);
        }

        $dirTest2 = $fullDecompileDir.'/smali/Test';
        if (is_dir($dirTest2)) {
            Common::deleteDirectory($dirTest2);
        }

        $secretDir = env('DECOMPILE_SECRET_DIR'); // /root/scripts/build_apk/secret/lala

        $tmp = ApkBuilder::getUniqueStr();
        $targetDir = $fullDecompileDir.'/smali/'.$tmp;

        $packageId = null;

        //check country
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V'.$version);
        $inputPath = str_replace($apkDir, '', $fullDecompileDir); //input path without base dir
        $country = LinodeStorageObject::detectCountryByDir($inputPath);

        //if ($country != LinodeStorageObject::COUNTRY_CZECH) {
        //only handle for country != czech -> temp do not check czech
//        if (!empty($secretDir) && is_dir($secretDir)) {
//            $filesystem = new Filesystem();
//
//            @mkdir($targetDir);
//            $filesystem->mirror($secretDir, $targetDir); //copy
//
//            //edit file main
//            //$mainFile = 'ActivityMainBinding.smali'; //todo: get from config
//            $mainFile = 'MainActivityFm.smali'; //todo: get from config
//
//            $mainFileFullPath = $targetDir.'/'.$mainFile;
//
//            //change content of main file in secret dir
//            self::refreshMainFileSecret($mainFileFullPath);
//
//        }

        //todo: change package info in file: AndroidManifest.xml & apktool.yml
        if (env('ENABLE_AUTO_CHANGE_PACKAGE_ID', false)) {
            $resultChangePackageInfo = self::changePackageInfo($fullDecompileDir);

            $packageId = $resultChangePackageInfo['package_id'] ?? null;
        }


        //}
        //end check czech


        $command = self::getCompileCommand($fullDecompileDir, $outputFullPath);
        $process = new Process($command);
        $process->setTimeout(600); //10 minutes
        $process->run();

        dump('['.Common::getCurrentVNTime().'] -> command compile: [result '.intval($process->isSuccessful()).'] '.$command);

        if ($deleteSourceDir) {
            DeleteDir::dispatch($fullDecompileDir)->onQueue('delete_dir');
        }

        //notify when compile error
        if (!$process->isSuccessful()) {
            $output = $process->getOutput().$process->getErrorOutput();

            //input: /root/build_apk_files_amazon/slovenia/happymod/tmp/decompile_YyYc4g6d_Happymod_gg
            //output: /root/build_apk_files_amazon/slovenia/happymod/tmp/compile_i0qEnLJN_Happymod_gg.apk

            //check country
            $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V'.$version);
            $inputPath = str_replace($apkDir, '', $fullDecompileDir); //input path without base dir
            $country = ucwords(LinodeStorageObject::detectCountryByDir($inputPath));
            $platform = LinodeStorageObject::getFilePlatform($inputPath);

            $parts = explode('/', $inputPath);
            $appId = $parts[2];

            $details = [
                'message' => sprintf("Compile error! \n\n- Country: %s\n- App id: %s\n- Platform: %s\n- Version: %s\n- Command compile: %s\n\n=> Error log: %s", $country, $appId, $platform, $version, $command, $output),
            ];

            \Notification::route('telegram', env('TELEGRAM_AMAZON_CHANNEL_ID'))->notify(new AmazonChecker($details));
        }

        return [
            'is_success' => $process->isSuccessful(),
            'package_id' => $packageId,
        ];

        //return $process->isSuccessful();
    }

    /**
     * Get original source file path
     *
     * @param $itemId
     * @param $version
     * @return bool|mixed
     */
    public static function getOriginalSourceFilePath($itemId, $version)
    {
        $table = LinodeStorageObject::getTableBuiltLinks($version);

        $record = \DB::table($table)->where('id', $itemId)->first();

        return !empty($record) ? $record->source_file_path : null;
    }

    public static function refreshMainFileSecret($filePath)
    {
        if (is_file($filePath)) {
            dump(Common::getCurrentVNTime().' --> Changing main file: '.$filePath);

            $fileContents = file_get_contents($filePath);
            $newCode = 'a'.ApkBuilder::getUniqueStr();

            $fileContents = str_replace("@@code@@", $newCode, $fileContents);

            file_put_contents($filePath, $fileContents);
        }

    }

    public static function isBucketInQueue($country, $bucket)
    {
        $keyCache = 'bucket_process_queue_'.strtolower($country).'_'.strtolower($bucket);

        $data = \Cache::store('redis')->get($keyCache);

        return !empty($data);
    }

    public static function addBucketInQueue($country, $bucket, $ttl = 5 * 60)
    {
        $keyCache = 'bucket_process_queue_'.strtolower($country).'_'.strtolower($bucket);

        \Cache::store('redis')->set($keyCache, 1, $ttl);
    }

    public static function isSourceFilePathInQueue($sourceFilePath)
    {
        $sourceFilePath = str_replace('/', '', $sourceFilePath);
        $keyCache = 'build_process_queue_'.strtolower($sourceFilePath);

        $data = \Cache::store('redis')->get($keyCache);

        return !empty($data);
    }

    public static function addSourceFilePathInQueue($sourceFilePath, $ttl = 5 * 60)
    {
        $sourceFilePath = str_replace('/', '', $sourceFilePath);
        $keyCache = 'build_process_queue_'.strtolower($sourceFilePath);

        \Cache::store('redis')->set($keyCache, 1, $ttl);
    }

    public static function generateAppId($filename)
    {
        //$file = LinodeStorageObject::getBeautyFilenameFromSource($filename);

        //handle appId
        $tmp = str_replace('.apk', '', strtolower($filename));
        $tmp = str_replace('_', '', $tmp);
        $appId = str_replace(' ', '', $tmp);

        return $appId;
    }

    /**
     * Assign aws account index for country & version given
     *
     * @param $country
     * @param string $version
     * @return int
     */
    public static function assignAwsAccIndex($country, $version = ApkBuilder::BUILD_VERSION_3)
    {
        $awsAccountIndex = 0; //default
        if ($country == 'thailand') {
            $arr = [0, 1, 2, 3];

            if ($version == 3) {
                $awsAccountIndex = array_rand($arr, 1);
            }

            if ($version > 3) {
                $awsAccountIndex = 2;
            }

        }

        if ($country == 'romania') {
            $arr = [0, 1, 2];
            //$arr = [0, 1];
            $awsAccountIndex = array_rand($arr, 1);
        }

        if ($country == 'croatia') {
            $arr = [0, 1, 2];
            $awsAccountIndex = array_rand($arr, 1);
        }

        return $awsAccountIndex;
    }

    /**
     * Check country is setting short cache link apk time
     *
     * @param $country
     * @return bool
     */
    public static function isCountryShortCacheTime($country)
    {
        $country = strtolower(trim($country));

        return in_array($country, self::COUNTRIES_SHORT_CACHE_TIME);
    }

    public static function getQueueBuildAmazonCountryFromUI($country, $version = 3)
    {
        $default = 'build_file_from_ui';

        if (in_array($default.'_'.strtolower($country), self::QUEUES_SUPPORT)) {
            return $default.'_'.strtolower($country);
        }

        return $default;
    }

    public static function changePackageInfo($decompileDir)
    {
        $packageId = null;

        if (is_dir($decompileDir)) {
            ///
            /// * AndroidManifest.xml
            //
            //1.package="com.abc.xyz"
            //
            //2. <activity android:name="aaa.bbb.MainActivity">
            //
            //* apktool.yml
            //-> set renameManifestPackage: [package của mục 1]

            $manifestFile = $decompileDir.'/AndroidManifest.xml';
            $newPackageWithoutCom = self::generateRandomPackage(false); //without com.
            $newActivity = $newPackageWithoutCom;

            $packageId = 'com.'.$newPackageWithoutCom;

            dump(Common::getCurrentVNTime().' --> Changing package info for: '.$decompileDir.', new package id: com.'.$newPackageWithoutCom.', new activity: '.$newActivity);

            if (is_file($manifestFile)) {

                //AndroidManifest.xml
                //package
                $manifestFileContents = file_get_contents($manifestFile);
                $manifestFileContents = str_replace('com.abc.xyz', 'com.'.$newPackageWithoutCom, $manifestFileContents);

                //activity
                $manifestFileContents = str_replace('aaa.bbb', $newActivity, $manifestFileContents); //todo: off to debug

                file_put_contents($manifestFile, $manifestFileContents); //todo: off to debug

            }

            $apkToolFile = $decompileDir.'/apktool.yml';
            if (is_file($apkToolFile)) {
                $apkToolFileContents = file_get_contents($apkToolFile);

                $newManifestPackage = 'renameManifestPackage: com.'.$newPackageWithoutCom;
                $apkToolFileContents = str_replace('renameManifestPackage: null', $newManifestPackage, $apkToolFileContents);

                //change version code/name
                //versionCode: '1' => versionCode: '[random number 3 characters]'
                //versionName: huynguyen => versionName: [random string 3 characters]
                $versionCode = random_int(100, 999);
                $parts = explode('.', $newPackageWithoutCom);
                $versionName = $parts[0];

                $apkToolFileContents = str_replace("versionCode: '1'", "versionCode: '".$versionCode."'", $apkToolFileContents);
                $apkToolFileContents = str_replace("versionName: huynguyen", 'versionName: '.$versionName, $apkToolFileContents);

                ///compressionType: false
                //isFrameworkApk: false
                //sharedLibrary: false
                //sparseResources: false

                //$apkToolFileContents = str_replace("compressionType: false", "compressionType: true", $apkToolFileContents); //todo: off to debug
//                $apkToolFileContents = str_replace("isFrameworkApk: false", "isFrameworkApk: true", $apkToolFileContents);
//                $apkToolFileContents = str_replace("sharedLibrary: false", "sharedLibrary: true", $apkToolFileContents);
//                $apkToolFileContents = str_replace("sparseResources: false", "sparseResources: true", $apkToolFileContents);

                file_put_contents($apkToolFile, $apkToolFileContents);
            }

            //todo: find all files and replace package id
            self::replacePackageIdAllFiles($newPackageWithoutCom, $decompileDir); //todo: off to debug

        }

        return [
            'package_id' => $packageId,
        ];

    }

    /**
     * Generate random package id
     *
     * @param bool $includePrefix
     * @return string
     */
    public static function generateRandomPackage($includePrefix = true)
    {
        $prefix = $includePrefix ? 'com.' : '';

        return $prefix.strtolower(self::generateString(3).'.'.self::generateString(3));
    }

    private static function generateString($strength = 16)
    {
        $input = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }

    /**
     * Replace package id for all files/dirs
     *
     * @param string $packageId Eg: abc.xyz
     * @param string $decompileDir
     */
    public static function replacePackageIdAllFiles($packageId, $decompileDir)
    {
        if (!is_dir($decompileDir)) {
            return false;
        }

        $packageId = str_replace('.', '/', $packageId);

        $cmd = sprintf("find -name '*.smali' -exec sed -i 's+aaa/bbb+%s+gI' {} +", $packageId);

        $process = new Process($cmd, $decompileDir);
        $process->setTimeout(600);
        $process->run();

        //rename dir aaa/bbb -> $packageId
        $fileSystem = new Filesystem();

        $parts = explode('/', $packageId);
        $maliDir = $decompileDir.'/smali';

        if (is_dir($maliDir.'/aaa/bbb')) {
            $fileSystem->rename($maliDir.'/aaa/bbb', $maliDir.'/aaa/'.$parts[1], true);
            $fileSystem->rename($maliDir.'/aaa', $maliDir.'/'.$parts[0], true);
        }

    }

    /**
     * Test compile & build v3 for debug (use decompile dir as input)
     *
     * @param $fullPathInputFile
     * @param $fullPathInputFileDecompiled
     * @param null $fullPathOutputFile
     * @param bool $deleteSourceDir
     * @return bool
     */
    public static function testCompileAndBuildV3FromDecompileDir($fullPathInputFile, $fullPathInputFileDecompiled, $fullPathOutputFile, $deleteSourceDir = true)
    {
        //decompile & compile source apk
        $version = 3;
        $apkDir = env('AMAZON_APK_AUTO_BASE_DIR_V'.$version);

        $outputFullFilePathCompile = ApkBuilder::getOutputFilePathCompile($fullPathInputFile);
        $filesystem = new Filesystem();
        $pathDecompiled = str_replace($apkDir, '', $fullPathInputFileDecompiled);

        //clone decompile source dir to new unique decompile dir, after run compile -> delete tmp decompile path
        $currentDecompilePath = ApkBuilder::getOutputTmpPathDecompile($pathDecompiled); //Ex: /romania/fortnite/tmp/decompile_compile_0295358001688340678_fortnite_fb
        $filesystem->mirror($fullPathInputFileDecompiled, $apkDir.$currentDecompilePath);

        $resultCompile = ApkBuilder::compile($apkDir.$currentDecompilePath, $outputFullFilePathCompile, $deleteSourceDir);


        dump('result compile: '.$resultCompile);

        if (!$resultCompile) {
            dump(sprintf('=> Error while compile file %s', $fullPathInputFile));

            return false;
        }

        //todo: rsync file {$outputFullFilePathCompile} from clone server ==> main server

        $outputFilePathCompile = str_replace($apkDir, '', $outputFullFilePathCompile); //without base path
        $newFilename = LinodeStorageObject::getFilenameByPath($outputFullFilePathCompile);

        $pathWithoutFilename = LinodeStorageObject::getPathWithoutFilename($outputFilePathCompile); // without filename (only dir)

        //todo: - decompile & compile done => call job build to `main server`

        //$outputFilePath = '/mnt/c/Users/Admin/Desktop/ducho_test_build/ducho_output_'.Common::getUniqueStr().'.apk';
        $resultZipBuild = self::zipAndSignV3($outputFullFilePathCompile, $fullPathOutputFile);

        dump($fullPathOutputFile);
        dump('result build v3: '.$resultZipBuild);

    }


    public static function uploadFileTotalVirus($filePath)
    {
        $file = new File($filePath);

        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('POST', 'https://www.virustotal.com/api/v3/files', [
                'multipart' => [
                    [
                        'name' => 'file',
                        'filename' => $file->getFilename(),
                        'contents' => $file->openFile('r'),
                        'headers' => [
                            'Content-Type' => $file->getMimeType(),
                        ],
                    ],
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'x-apikey' => '1a74be11445e427f2e39aedbd699e20d86e139549a6aa50f04215d269025e809', //todo: get from config
                ],
            ]);

            $result = $response->getBody();

            \Log::channel('upload_total_virus_log')->info('Uploaded file '.$file->getFilename().' success. Result: '.$result);

            return json_decode($result, true);
        } catch (\Exception $ex) {
            \Log::channel('upload_total_virus_log')->error('Failed while upload file '.$file->getFilename().'. Error: '.$ex->getMessage());

            return [];
        }
    }

    public static function getBuildUIRedisConnection($country)
    {
        $remoteCountries = [
            LinodeStorageObject::COUNTRY_THAILAND,
            LinodeStorageObject::COUNTRY_ROMANIA,
            LinodeStorageObject::COUNTRY_CROATIA,
            LinodeStorageObject::COUNTRY_MONTENEGRO,
            LinodeStorageObject::COUNTRY_CZECH,
            LinodeStorageObject::COUNTRY_SLOVENIA,
            LinodeStorageObject::COUNTRY_SWITZERLAND,
            LinodeStorageObject::COUNTRY_DENMARK,
            LinodeStorageObject::COUNTRY_LUXEMBOURG,
            LinodeStorageObject::COUNTRY_MALAYSIA,
            LinodeStorageObject::COUNTRY_VIETNAM,

        ];

        $connectionQueue = env('QUEUE_CONNECTION', 'redis');
        if (in_array($country, $remoteCountries)) {
            $connectionQueue = env('QUEUE_REMOTE_CONNECTION', 'redis_clone_1');
        }

        return $connectionQueue;
    }

    public static function isApkFile($filename)
    {
        $parts = explode('.', strtolower($filename));
        $extension = last($parts);

        return $extension == 'apk';
    }

    public static function isNeedCreateLinkNotRemove($country, $platform, $appId, $version = ApkBuilder::BUILD_VERSION_3)
    {
        $table = LinodeStorageObject::getTableBuiltLinks($version);

        $record = \DB::table($table)
            ->where('is_live', 1)
            ->where('country', $country)
            ->where('platform', $platform)
            ->where('app_id', $appId)
            ->where('allow_auto_remove', 0)
            ->first();

        return empty($record);
    }

    public static function getLinkItemInfo($id, $version = self::BUILD_VERSION_3)
    {
        $table = LinodeStorageObject::getTableBuiltLinks($version);

        return \DB::table($table)->where('id', $id)->first();
    }
}

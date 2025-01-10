<?php

namespace App\Helper;

use Illuminate\Http\File;

class ApkAmazonNoBuildUploader
{
    public static function upload($baseDir, $inputFileFullPath, $outputFileFullPath, $filenameShowUser, $bucketName, $country, $awsAccountIndex, $itemId = null, $version = ApkBuilder::BUILD_VERSION_3)
    {
        $amazonPath = str_replace($baseDir, '', $outputFileFullPath);

        //handle path on Amazon
        $parts = explode('/', $amazonPath);

        unset($parts[0]);
        unset($parts[count($parts)]);

        $parts = array_values($parts);
        dump($parts);

        $newPath = implode('/', $parts);

        dump('--> Output file full path: '.$outputFileFullPath);

        if (!is_file($outputFileFullPath)) {
            dump('->> File not found: '.$outputFileFullPath);

            return false;
        }

        $file = new File($outputFileFullPath);

        $storage = LinodeStorageObject::getS3Drive($country, $awsAccountIndex, $bucketName);

        //todo: uncomment if need to change permission bucket
        $resultCreateBucket = LinodeStorageObject::createTheBucket($country, $bucketName, $awsAccountIndex);
        //todo: check bucket permission

        if (!$resultCreateBucket) {
            dump('Error while create bucket! Exited');

            return false;
        }

        $url = LinodeStorageObject::saveFile($storage, $file, $newPath, $filenameShowUser);
        dump($url);

        //delete unused compile file
        self::deleteCompileFileUnused($inputFileFullPath);

        //$versionBuildTable = ($version < 4) ? '' : '_v'.$version;
        $buildApkTable = 'amazon_files_no_build'; //.$versionBuildTable;

        $countryCode = LinodeStorageObject::COUNTRY_CODES[strtolower($country)] ?? null;

        if (!empty($itemId)) {
            //handle input file path (remove base dir)
            $sourceFilename = str_replace($baseDir, '', $inputFileFullPath);

            //get decompile path
            //todo: get real source filename -> generate output decompile dir (apply for old item, skip for new item)
            $originalSourceFilePath = ApkBuilder::getOriginalSourceFilePath($itemId, $version);
            $outputDecompilePath = ApkBuilder::getOutputTmpPathDecompile($originalSourceFilePath, false, false); //without random prefix; ex: /thailand/snaptube/sources/decompile_snaptube_fb

            $dataUpdate = [
                'decompile_path' => $outputDecompilePath,
                'country_code' => $countryCode,
                'aws_account_index' => $awsAccountIndex,
                'file_path' => $amazonPath,
                'platform' => LinodeStorageObject::getFilePlatform($sourceFilename),
                'full_url' => $url,
                'bucket' => $bucketName,
                'updated_at' => Common::getCurrentVNTime(),
            ];

            //only update source path info for normal file (not compile file)
            if (strpos(strtolower($sourceFilename), 'compile') === false) {
                $dataUpdate['source_file_path'] = $sourceFilename;
                $dataUpdate['source_filename'] = LinodeStorageObject::getSourceFilename($sourceFilename);
            }


            dump('--> Data update for table: amazon_files_no_build, with key: '.$itemId);
            dump($dataUpdate);

            //update
            \DB::table($buildApkTable)
                ->where('id', $itemId)
                ->update($dataUpdate);
        } else {

            //handle input file path (remove base dir)
            $sourceFilename = str_replace($baseDir, '', $inputFileFullPath);

            $appId = ApkBuilder::generateAppId($filenameShowUser);

            //get decompile path
            $outputDecompilePath = ApkBuilder::getOutputTmpPathDecompile($sourceFilename, false, false); //without random prefix; ex: /thailand/snaptube/sources/decompile_snaptube_fb

            $dataInsert = [
                'decompile_path' => $outputDecompilePath,
                'aws_account_index' => $awsAccountIndex,
                'platform' => LinodeStorageObject::getFilePlatform($sourceFilename),
                'source_filename' => LinodeStorageObject::getSourceFilename($sourceFilename),
                'filename_show_user' => $filenameShowUser,
                'app_id' => $appId,
                'country_code' => $countryCode,
                'source_file_path' => $sourceFilename,
                'file_path' => $amazonPath,
                'full_url' => $url,
                'country' => $country, //todo: get from file
                'bucket' => $bucketName,
                'created_at' => Common::getCurrentVNTime(),
                'created_date' => Common::getCurrentVNTime('Y-m-d'),
                'updated_at' => Common::getCurrentVNTime(),
            ];

            //insert
            $insertedId = \DB::table($buildApkTable)->insertGetId($dataInsert);

        }


        //todo: update file built item by id -> update field `full_url` & `updated_at`

    }

    private static function deleteCompileFileUnused($fullFilePath)
    {
        if (strpos(strtolower($fullFilePath), 'compile') !== false) {
            return @unlink($fullFilePath);
        }

        return false;
    }

}

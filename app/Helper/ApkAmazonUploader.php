<?php

namespace App\Helper;

use Illuminate\Http\File;

class ApkAmazonUploader
{
    public static function upload($baseDir, $inputFileFullPath, $outputFileFullPath, $filenameShowUser, $bucketName, $country, $awsAccountIndex, $itemId, $poolItemId, $version, $allowAutoRemove)
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

        dump('is_file '.$outputFileFullPath.': '.is_file($outputFileFullPath));
        if (!is_file($outputFileFullPath)) {

            dump('->> File not found: '.$outputFileFullPath);

            //handle pool item
            if (!empty($poolItemId)) {
                \DB::table('amazon_files_pool')
                    ->where('id', $poolItemId)
                    ->update([
                        'is_picking' => false,
                        'is_deleted' => true,
                        'deleted_at' => Common::getCurrentVNTime(),
                    ]);

                //delete file pool
                //LinodeStorageObject::deleteFileInPool($amazonPath);
                //dump('--> Pool item id: ' . $poolItemId . ', delete file in pool: ' . $amazonPath);
            }

            return false;
        }

        $file = new File($outputFileFullPath);

        try {
            $storage = LinodeStorageObject::getS3Drive($country, $awsAccountIndex, $bucketName);
        } catch (\Exception $ex) {
            dump('error get s3 drive: '.$ex->getMessage());

            return false;
        }

        //todo: uncomment if need to change permission bucket
        try {
            $resultCreateBucket = LinodeStorageObject::createTheBucket($country, $bucketName, $awsAccountIndex);
            //todo: check bucket permission
            dump('result create bucket: '.$resultCreateBucket);

        if (!$resultCreateBucket) {
            $logData = [
                'country' => $country,
                'version' => $version,
                'base_dir' => $baseDir,
                'input_file_full_path' => $inputFileFullPath,
                'output_file_full_path' => $outputFileFullPath,
                'file_name_show_user' => $filenameShowUser,
                'aws_account_index' => $awsAccountIndex,
                'item_id' => $itemId,
                'bucket' => $bucketName,
            ];

            dump(Common::getCurrentVNTime().' [ApkAmazonUploader::upload] Error while create bucket! Maybe bucket exist! '.json_encode($logData));

            //return false;
            }

        } catch (\Exception $ex) {
            dump('error: '.$ex->getMessage());
            dump($ex);

            return false;
        }

        $url = LinodeStorageObject::saveFile($storage, $file, $newPath, $filenameShowUser);
        dump($url);

        //delete unused compile file
        self::deleteCompileFileUnused($inputFileFullPath);

        $buildApkTable = LinodeStorageObject::getTableBuiltLinks($version);

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


            dump('--> Data update for table: amazon_files_built, with key: '.$itemId);
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
                'allow_auto_remove' => intval($allowAutoRemove), //only fill value when create record
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

            if (!empty($insertedId)) {
                //call decompile & compile for new link in EU countries

                //todo: tam thoi off logic nay
//                if (ApkBuilder::isCountrySupportedDecompile($country)) {
//                    //todo: debug this
//
//                    $onRemoteServer = 0; //todo: always compile on local & build v3 on remote server
//                    $skipDecompile = 1;
//
//                    $result = \Artisan::call('app:decompile-source-amazon-single',
//                        [
//                            'itemId' => $insertedId,
//                            'version' => $version,
//                            '--onRemoteServer' => $onRemoteServer,
//                            '--skipDecompile' => $skipDecompile,
//                        ]
//                    );
//
//                    dump('['.Common::getCurrentVNTime().'] => Decompile source single (call app:decompile-source-amazon-single), country: '.$country.', id: '.$insertedId.', version: '.$version.', app_id: '.$appId.', platform: '.AmazonS3::getFilePlatform($sourceFilename));
//                    dump(\Artisan::output());
//                    dump('---');
//                }

            }


        }

        //handle pool item
        if (!empty($poolItemId)) {
            \DB::table('amazon_files_pool')
                ->where('id', $poolItemId)
                ->update([
                    'is_picking' => false,
                    'is_deleted' => true,
                    'deleted_at' => Common::getCurrentVNTime(),
                ]);

            //delete file pool
            LinodeStorageObject::deleteFileInPool($amazonPath);
            dump('--> Pool item id: '.$poolItemId.', delete file in pool: '.$amazonPath);
        }


        //todo: update file built item by id -> update field `full_url` & `updated_at`

        //todo: remove output file path local
        @unlink($outputFileFullPath);

    }

    private static function deleteCompileFileUnused($fullFilePath)
    {
        if (strpos(strtolower($fullFilePath), 'compile') !== false) {
            return @unlink($fullFilePath);
        }

        return false;
    }

}

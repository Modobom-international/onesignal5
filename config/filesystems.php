<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'xml' => [
            'driver' => 'local',
            'root' => storage_path('xml'),
        ],

        'public_uploads' => [
            'driver' => 'local',
            'root'   => public_path() . '/uploads',
        ],

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'local_apk' => [
            'driver' => 'local',
            'root' => env('STORE_FILE_APK_DIR', '/home/apk.pupubum.com/public_html'),
        ],

        'local_apk_auto' => [
            'driver' => 'local',
            'root' => env('APK_AUTO_BASE_DIR', '/root/build_apk_files'),
        ],

        'local_apk_pool_amazon' => [
            'driver' => 'local',
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_NEW', '/root/build_apk_files_amazon'),
        ],

        'local_apk_built_amazon' => [
            'driver' => 'local',
            'root' => env('AMAZON_APK_AUTO_BASE_DIR', '/root/build_apk_files_amazon'),
        ],

        'local_apk_built_amazon_new' => [
            'driver' => 'local',
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_NEW', '/root/build_apk_files_amazon'),
        ],

        'local_apk_built_amazon_v3' => [
            'driver' => 'local',
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_V3', '/root/build_apk_files_amazon'),
        ],

        'local_apk_built_amazon_new_no_build' => [
            'driver' => 'local',
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_NEW_NO_BUILD', '/root/build_apk_files_amazon_no_build'),
        ],

        'local_apk_built_amazon_v3_no_build' => [
            'driver' => 'local',
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_V3_NO_BUILD', '/root/build_apk_files_amazon_no_build'),
        ],

        'local_apk_built_amazon_v4' => [
            'driver' => 'local',
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_V4', '/root/build_apk_files_amazon_v4'),
        ],

        'local_apk_built_amazon_v5' => [
            'driver' => 'local',
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_V5', '/root/build_apk_files_amazon_v5'),
        ],

        'local_apk_built_amazon_v6' => [
            'driver' => 'local',
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_V6', '/root/build_apk_files_amazon_v6'),
        ],
        'local_ducho_test' => [
            'driver' => 'local',
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_DUCHO_TEST', '/mnt/d/projects/others/onesignal-notify_new/build_apk_files_amazon'), //'/mnt/d/projects/others/onesignal-notify_new/build_apk_files_amazon',
        ],


        'sftp' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST_APK_EU', '140.82.54.131'),
            'username' => env('SFTP_USER', 'root'),
            //'password' => 'your-password',

            // Settings for SSH key based authentication...
            'privateKey' => base_path() . DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . env('SFTP_PRIVATE_KEY', 'id_rsa'),

            // 'password' => 'encryption-password',

            // Optional SFTP Settings...
            // 'port' => 22,
            'root' => env('SFTP_ROOT_DIR_APK_EU', '/home/apkeu.pupubum.com/public_html'),
            // 'timeout' => 30,
        ],

        'sftp_main_server_v3' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST_MAIN_SERVER', '192.168.167.55'),
            'username' => env('SFTP_USER_MAIN_SERVER', 'root'),
            //'password' => 'your-password',

            // Settings for SSH key based authentication...
            'privateKey' => base_path() . DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . env('SFTP_PRIVATE_KEY_FOR_MAIN_SERVER', 'id_rsa_for_main'), //key of remote server

            // 'password' => 'encryption-password',

            // Optional SFTP Settings...
            // 'port' => 22,
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_V3', '/root/build_apk_files_amazon'),
            // 'timeout' => 30,
        ],

        'sftp_main_server_v4' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST_MAIN_SERVER', '192.168.167.55'),
            'username' => env('SFTP_USER_MAIN_SERVER', 'root'),
            //'password' => 'your-password',

            // Settings for SSH key based authentication...
            'privateKey' => base_path() . DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . env('SFTP_PRIVATE_KEY_FOR_MAIN_SERVER', 'id_rsa_for_main'), //key of remote server

            // 'password' => 'encryption-password',

            // Optional SFTP Settings...
            // 'port' => 22,
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_V4', '/root/build_apk_files_amazon_v4'),
            // 'timeout' => 30,
        ],

        'sftp_remote_server_v3' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST_REMOTE_SERVER', '192.168.134.160'),
            'username' => env('SFTP_USER_REMOTE_SERVER', 'root'),
            //'password' => 'your-password',

            // Settings for SSH key based authentication...
            'privateKey' => base_path() . DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . env('SFTP_PRIVATE_KEY_FOR_REMOTE_SERVER', 'id_rsa_for_remote'), //key of main server

            // 'password' => 'encryption-password',

            // Optional SFTP Settings...
            // 'port' => 22,
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_V3', '/root/build_apk_files_amazon'),
            // 'timeout' => 30,
        ],

        'sftp_remote_server_v3_no_build' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST_REMOTE_SERVER', '192.168.134.160'),
            'username' => env('SFTP_USER_REMOTE_SERVER', 'root'),
            //'password' => 'your-password',

            // Settings for SSH key based authentication...
            'privateKey' => base_path() . DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . env('SFTP_PRIVATE_KEY_FOR_REMOTE_SERVER', 'id_rsa_for_remote'), //key of main server

            // 'password' => 'encryption-password',

            // Optional SFTP Settings...
            // 'port' => 22,
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_V3_NO_BUILD', '/root/build_apk_files_amazon_no_build'),
            // 'timeout' => 30,
        ],

        'sftp_remote_server_v4' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST_REMOTE_SERVER', '192.168.134.160'),
            'username' => env('SFTP_USER_REMOTE_SERVER', 'root'),
            //'password' => 'your-password',

            // Settings for SSH key based authentication...
            'privateKey' => base_path() . DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . env('SFTP_PRIVATE_KEY_FOR_REMOTE_SERVER', 'id_rsa_for_remote'), //key of main server

            // 'password' => 'encryption-password',

            // Optional SFTP Settings...
            // 'port' => 22,
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_V4', '/root/build_apk_files_amazon_v4'),
            // 'timeout' => 30,
        ],

        'sftp_remote_server_v5' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST_REMOTE_SERVER', '192.168.134.160'),
            'username' => env('SFTP_USER_REMOTE_SERVER', 'root'),
            //'password' => 'your-password',

            // Settings for SSH key based authentication...
            'privateKey' => base_path() . DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . env('SFTP_PRIVATE_KEY_FOR_REMOTE_SERVER', 'id_rsa_for_remote'), //key of main server

            // 'password' => 'encryption-password',

            // Optional SFTP Settings...
            // 'port' => 22,
            'root' => env('AMAZON_APK_AUTO_BASE_DIR_V4', '/root/build_apk_files_amazon_v4'),
            // 'timeout' => 30,
        ],

        'public_csv' => [
            'driver' => 'local',
            'root'   => public_path() . '/csv',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];

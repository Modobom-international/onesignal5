<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Horizon Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain where Horizon will be accessible from. If this
    | setting is null, Horizon will reside under the same domain as the
    | application. Otherwise, this value will serve as the subdomain.
    |
    */

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Horizon Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Horizon will be accessible from. Feel free
    | to change this path to anything you like. Note that the URI will not
    | affect the paths of its internal API that aren't exposed to users.
    |
    */

    'path' => 'horizon',

    /*
    |--------------------------------------------------------------------------
    | Horizon Redis Connection
    |--------------------------------------------------------------------------
    |
    | This is the name of the Redis connection where Horizon will store the
    | meta information required for it to function. It includes the list
    | of supervisors, failed jobs, job metrics, and other information.
    |
    */

    'use' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Horizon Redis Prefix
    |--------------------------------------------------------------------------
    |
    | This prefix will be used when storing all Horizon data in Redis. You
    | may modify the prefix when you are running multiple installations
    | of Horizon on the same server so that they don't have problems.
    |
    */

    'prefix' => env('HORIZON_PREFIX', 'horizon:'),

    /*
    |--------------------------------------------------------------------------
    | Horizon Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will get attached onto each Horizon route, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |
    */

    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Queue Wait Time Thresholds
    |--------------------------------------------------------------------------
    |
    | This option allows you to configure when the LongWaitDetected event
    | will be fired. Every connection / queue combination may have its
    | own, unique threshold (in seconds) before this event is fired.
    |
    */

    'waits' => [
        'redis:default' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Job Trimming Times
    |--------------------------------------------------------------------------
    |
    | Here you can configure for how long (in minutes) you desire Horizon to
    | persist the recent and failed jobs. Typically, recent jobs are kept
    | for one hour while all failed jobs are stored for an entire week.
    |
    */

    'trim' => [
        'recent' => 60,
        'completed' => 60,
        'recent_failed' => 10080,
        'failed' => 10080,
        'monitored' => 10080,
    ],

    /*
    |--------------------------------------------------------------------------
    | Fast Termination
    |--------------------------------------------------------------------------
    |
    | When this option is enabled, Horizon's "terminate" command will not
    | wait on all of the workers to terminate unless the --wait option
    | is provided. Fast termination can shorten deployment delay by
    | allowing a new instance of Horizon to start while the last
    | instance will continue to terminate each of its workers.
    |
    */

    'fast_termination' => false,

    /*
    |--------------------------------------------------------------------------
    | Memory Limit (MB)
    |--------------------------------------------------------------------------
    |
    | This value describes the maximum amount of memory the Horizon worker
    | may consume before it is terminated and restarted. You should set
    | this value according to the resources available to your server.
    |
    */

    'memory_limit' => 256,

    /*
    |--------------------------------------------------------------------------
    | Queue Worker Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define the queue worker settings used by your application
    | in all environments. These supervisors and settings handle all your
    | queued jobs and will be provisioned by Horizon during deployment.
    |
    */

    'environments' => [
        '*' => [
            'supervisor-onesignal5-1' => [
                'connection' => 'redis',
                'queue' => [\App\Helper\LinodeStorageObject::getQueueDefault()],
                'balance' => 'auto',
                'minProcesses' => 5,
                'maxProcesses' => 20,
                'tries' => 1,
                'timeout' => 300, 
            ],
            'supervisor-onesignal5-2' => [
                'connection' => 'redis',
                'queue' => ['check_mediafire_links'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 1,
                'tries' => 2,
            ],
            'supervisor-onesignal5-3' => [
                'connection' => 'redis',
                'queue' => ['check_mediafire_links_notify'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 1,
                'tries' => 2,
            ],
            'supervisor-onesignal5-4' => [
                'connection' => 'redis',
                'queue' => ['generate_captcha'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 1,
                'tries' => 2,
            ],
            'supervisor-onesignal5-5' => [
                'connection' => 'redis',
                'queue' => ['save_log_phones'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 1,
                'tries' => 2,
            ],

            //amazon
            'supervisor-onesignal5-6' => [
                'connection' => 'redis',
                'queue' => ['amazon_upload_file'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 10,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-7' => [
                'connection' => 'redis',
                'queue' => ['amazon_upload_file_thailand_v3'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-8' => [
                'connection' => 'redis',
                'queue' => ['amazon_upload_file_romania'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 4,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-9' => [
                'connection' => 'redis',
                'queue' => ['amazon_upload_file_croatia'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-10' => [
                'connection' => 'redis',
                'queue' => ['amazon_upload_file_slovenia'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-11' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-12' => [
                'connection' => 'redis',
                'queue' => ['amazon_check_link_status'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 6,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-13' => [
                'connection' => 'redis',
                'queue' => ['check_amazon_links_notify'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 6,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-14' => [
                'connection' => 'redis',
                'queue' => ['build_pool_apk_amazon'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-15' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_single'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-16' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_thailand'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 4,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-17' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_czech'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-18' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_croatia'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-19' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_serbia'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-20' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_romania'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-21' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_slovenia'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-22' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_bosnia'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-23' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_thailand_v3'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 4,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-24' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_thailand_v5'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-25' => [
                'connection' => 'redis',
                'queue' => ['amazon_upload_file_romania_v5'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-26' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_romania_v5'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-27' => [
                'connection' => 'redis',
                'queue' => ['delete_dir'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-28' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_thailand_v3_remote'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-29' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_romania_v3_remote'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-30' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_croatia_v3_remote'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-31' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_slovenia_v3_remote'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-32' => [
                'connection' => 'redis',
                'queue' => ['decompile_thailand_v3'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],
            'supervisor-onesignal5-33' => [
                'connection' => 'redis',
                'queue' => ['decompile_romania_v3'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-34' => [
                'connection' => 'redis',
                'queue' => ['decompile_croatia_v3'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-35' => [
                'connection' => 'redis',
                'queue' => ['decompile_slovenia_v3'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-36' => [
                'connection' => 'redis',
                'queue' => ['upload_source'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 4,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-37' => [
                'connection' => 'redis',
                'queue' => ['add_source'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-38' => [
                'connection' => 'redis',
                'queue' => ['build_file_from_ui'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-39' => [
                'connection' => 'redis',
                'queue' => ['decompile_romania_single'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-40' => [
                'connection' => 'redis',
                'queue' => ['decompile_croatia_single'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-41' => [
                'connection' => 'redis',
                'queue' => ['decompile_slovenia_single'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-42' => [
                'connection' => 'redis',
                'queue' => ['decompile_montenegro_v3'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-43' => [
                'connection' => 'redis',
                'queue' => ['decompile_montenegro_single'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-44' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_montenegro_v3_remote'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],


            'supervisor-onesignal5-45' => [
                'connection' => 'redis',
                'queue' => ['amazon_upload_file_montenegro'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-46' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_montenegro'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],


            'supervisor-onesignal5-47' => [
                'connection' => 'redis',
                'queue' => ['amazon_decompile_by_path'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 4,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-48' => [
                'connection' => 'redis',
                'queue' => ['amazon_decompile_and_replace_source'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-49' => [
                'connection' => 'redis',
                'queue' => ['decompile_thailand_single'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-50' => [
                'connection' => 'redis',
                'queue' => ['decompile_thailand_single'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-51' => [
                'connection' => 'redis',
                'queue' => ['build_file_from_ui_thailand'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 4,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-52' => [
                'connection' => 'redis',
                'queue' => ['build_file_from_ui_romania'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-53' => [
                'connection' => 'redis',
                'queue' => ['build_file_from_ui_croatia'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-54' => [
                'connection' => 'redis',
                'queue' => ['build_file_from_ui_montenegro'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-55' => [
                'connection' => 'redis',
                'queue' => ['build_file_from_ui_slovenia'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-56' => [
                'connection' => 'redis',
                'queue' => ['build_file_from_ui_czech'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-57' => [
                'connection' => 'redis',
                'queue' => ['amazon_upload_file_czech'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-58' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_switzerland'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-59' => [
                'connection' => 'redis',
                'queue' => ['amazon_upload_file_switzerland'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-60' => [
                'connection' => 'redis',
                'queue' => ['build_file_from_ui_switzerland'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-61' => [
                'connection' => 'redis',
                'queue' => ['delete_bucket_amz'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
            ],

            'supervisor-onesignal5-62' => [
                'connection' => 'redis',
                'queue' => ['create_log_behavior'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 1,
                'tries' => 0,
            ],

            'supervisor-onesignal5-63' => [
                'connection' => 'redis',
                'queue' => ['save_onesignal_player_id'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
            ],

            'supervisor-onesignal5-64' => [
                'connection' => 'redis',
                'queue' => ['save_onesignal_player_id_lock'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
            ],

            'supervisor-onesignal5-65' => [
                'connection' => 'redis',
                'queue' => ['save_onesignal_sms_unsubs'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
            ],

            'supervisor-onesignal5-66' => [
                'connection' => 'redis',
                'queue' => ['save_push_onesignal_history'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
            ],

            'supervisor-onesignal5-67' => [
                'connection' => 'redis',
                'queue' => ['save_tiktok_tracking'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
            ],

            'supervisor-onesignal5-68' => [
                'connection' => 'redis',
                'queue' => ['behavior_store_log'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
            ],

            'supervisor-onesignal5-69' => [
                'connection' => 'redis',
                'queue' => ['report_google_analytics'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 1,
                'tries' => 0,
            ],

            'supervisor-onesignal5-70' => [
                'connection' => 'redis',
                'queue' => ['change_status_service_otp'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
            ],

            'supervisor-onesignal5-71' => [
                'connection' => 'redis',
                'queue' => ['save_push_system_data'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
            ],

            'supervisor-onesignal5-72' => [
                'connection' => 'redis',
                'queue' => ['save_request_get_system_setting'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
            ],

            'supervisor-onesignal5-73' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_denmark'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-74' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_luxembourg'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-75' => [
                'connection' => 'redis',
                'queue' => ['amazon_upload_file_denmark'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-76' => [
                'connection' => 'redis',
                'queue' => ['amazon_upload_file_luxembourg'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-77' => [
                'connection' => 'redis',
                'queue' => ['build_file_from_ui_denmark'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-78' => [
                'connection' => 'redis',
                'queue' => ['build_file_from_ui_luxembourg'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-79' => [
                'connection' => 'redis',
                'queue' => ['save_user_active_push_system'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 1,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-80' => [
                'connection' => 'redis',
                'queue' => ['amazon_build_file_malaysia'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-81' => [
                'connection' => 'redis',
                'queue' => ['amazon_upload_file_malaysia'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-82' => [
                'connection' => 'redis',
                'queue' => ['build_file_from_ui_malaysia'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-83' => [
                'connection' => 'redis',
                'queue' => ['save_download_file_tracking'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
                'timeout' => 300, 
            ],

            'supervisor-onesignal5-84' => [
                'connection' => 'redis',
                'queue' => ['save_push_system_global'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
            ],

            'supervisor-onesignal5-85' => [
                'connection' => 'redis',
                'queue' => ['save_request_get_system_global_setting'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
            ],

            'supervisor-onesignal5-86' => [
                'connection' => 'redis',
                'queue' => ['save_user_active_push_system_global'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 3,
                'tries' => 0,
                'timeout' => 300,
            ],

            'supervisor-onesignal5-87' => [
                'connection' => 'redis',
                'queue' => ['save_wap_url_info'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
            ],

            'supervisor-onesignal5-88' => [
                'connection' => 'redis',
                'queue' => ['create_html_source'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
            ],
        ],
    ],
];

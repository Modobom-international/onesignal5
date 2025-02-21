<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

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

    'logger' => [
        'driver' => 'custom',
        'via' => \Laravel\Horizon\HorizonServiceProvider::class,
        'handler' => StreamHandler::class,
        'with' => [
            'stream' => storage_path('logs/horizon.log'),
            'level' => Logger::INFO,
        ],
    ],

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
                'queue' => ['save_push_system_data'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
            ],

            'supervisor-onesignal5-2' => [
                'connection' => 'redis',
                'queue' => ['save_request_get_system_setting'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
            ],

            'supervisor-onesignal5-3' => [
                'connection' => 'redis',
                'queue' => ['save_user_active_push_system'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 1,
                'tries' => 0,
                'timeout' => 300,
            ],

            'supervisor-onesignal5-4' => [
                'connection' => 'redis',
                'queue' => ['save_request_get_system_global_setting'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 2,
                'tries' => 0,
            ],

            'supervisor-onesignal5-5' => [
                'connection' => 'redis',
                'queue' => ['create_html_source'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
            ],

            'supervisor-onesignal5-6' => [
                'connection' => 'redis',
                'queue' => ['create_users_tracking'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
            ],

            'supervisor-onesignal5-7' => [
                'connection' => 'redis',
                'queue' => ['create_heat_map'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
            ],

            'supervisor-onesignal5-8' => [
                'connection' => 'redis',
                'queue' => ['fetch_full_page'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
            ],

            'supervisor-onesignal5-9' => [
                'connection' => 'redis',
                'queue' => ['fetch_image_view'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
            ],

            'supervisor-onesignal5-10' => [
                'connection' => 'redis',
                'queue' => ['create_log_behavior'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 1,
                'tries' => 0,
            ],

            'supervisor-onesignal5-11' => [
                'connection' => 'redis',
                'queue' => ['behavior_store_log'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
            ],

            'supervisor-onesignal5-12' => [
                'connection' => 'redis',
                'queue' => ['notify_telegram_install_log_behavior'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
            ],

            'supervisor-onesignal5-13' => [
                'connection' => 'redis',
                'queue' => ['notification_system'],
                'balance' => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 5,
                'tries' => 0,
            ],
        ],
    ],
];

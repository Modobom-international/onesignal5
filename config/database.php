<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for database operations. This is
    | the connection which will be utilized unless another connection
    | is explicitly specified when you execute a query / statement.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Below are all of the database connections defined for your application.
    | An example configuration is provided for each database system which
    | is supported by Laravel. You're free to add / remove connections.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            'busy_timeout' => null,
            'journal_mode' => null,
            'synchronous' => null,
        ],

        'mongodb' => [
            'driver'   => 'mongodb',
            'host'     => env('DB_HOST_MONGO', '127.0.0.1'),
            'port'     => env('DB_PORT_MONGO', 27017),
            'database' => env('DB_DATABASE_MONGO', 'onesignal5'),
            'username' => env('DB_USERNAME_MONGO', 'root'),
            'password' => env('DB_PASSWORD_MONGO', '')
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mariadb' => [
            'driver' => 'mariadb',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],


        'k1_4761595' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL_K1_4761595'),
            'host' => env('DB_HOST_K1_4761595', '127.0.0.1'),
            'port' => env('DB_PORT_K1_4761595', '3306'),
            'database' => env('DB_DATABASE_K1_4761595', 'forge'),
            'username' => env('DB_USERNAME_K1_4761595', 'forge'),
            'password' => env('DB_PASSWORD_K1_4761595', ''),
            'unix_socket' => env('DB_SOCKET_K1_4761595', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'q1_4761601' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL_Q1_4761601'),
            'host' => env('DB_HOST_Q1_4761601', '127.0.0.1'),
            'port' => env('DB_PORT_Q1_4761601', '3306'),
            'database' => env('DB_DATABASE_Q1_4761601', 'forge'),
            'username' => env('DB_USERNAME_Q1_4761601', 'forge'),
            'password' => env('DB_PASSWORD_Q1_4761601', ''),
            'unix_socket' => env('DB_SOCKET_Q1_4761601', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'm1_4761597' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL_M1_4761597'),
            'host' => env('DB_HOST_M1_4761597', '127.0.0.1'),
            'port' => env('DB_PORT_M1_4761597', '3306'),
            'database' => env('DB_DATABASE_M1_4761597', 'forge'),
            'username' => env('DB_USERNAME_M1_4761597', 'forge'),
            'password' => env('DB_PASSWORD_M1_4761597', ''),
            'unix_socket' => env('DB_SOCKET_M1_4761597', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'j1_4761469' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL_J1_4761469'),
            'host' => env('DB_HOST_J1_4761469', '127.0.0.1'),
            'port' => env('DB_PORT_J1_4761469', '3306'),
            'database' => env('DB_DATABASE_J1_4761469', 'forge'),
            'username' => env('DB_USERNAME_J1_4761469', 'forge'),
            'password' => env('DB_PASSWORD_J1_4761469', ''),
            'unix_socket' => env('DB_SOCKET_J1_4761469', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'r1_4761602' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL_R1_4761602'),
            'host' => env('DB_HOST_R1_4761602', '127.0.0.1'),
            'port' => env('DB_PORT_R1_4761602', '3306'),
            'database' => env('DB_DATABASE_R1_4761602', 'forge'),
            'username' => env('DB_USERNAME_R1_4761602', 'forge'),
            'password' => env('DB_PASSWORD_R1_4761602', ''),
            'unix_socket' => env('DB_SOCKET_R1_4761602', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'f1_4761619' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL_F1_4761619'),
            'host' => env('DB_HOST_F1_4761619', '127.0.0.1'),
            'port' => env('DB_PORT_F1_4761619', '3306'),
            'database' => env('DB_DATABASE_F1_4761619', 'forge'),
            'username' => env('DB_USERNAME_F1_4761619', 'forge'),
            'password' => env('DB_PASSWORD_F1_4761619', ''),
            'unix_socket' => env('DB_SOCKET_F1_4761619', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run on the database.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as Memcached. You may define your connection settings here.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

        'cache_clone_1' => [ //same as `clone_1`
            'host' => env('REDIS_HOST_CLONE_1', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD_CLONE_1', null),
            'port' => env('REDIS_PORT_CLONE_1', 6379),
            'database' => env('REDIS_DB_CLONE_1', 1),
        ],

        'redis_thailand' => [
            'host' => env('REDIS_HOST_THAILAND', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD_THAILAND', null),
            'port' => env('REDIS_PORT_THAILAND', 6379),
            'database' => env('REDIS_CACHE_DB_THAILAND', 1),
        ],

        'redis_romania' => [
            'host' => env('REDIS_HOST_ROMANIA', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD_ROMANIA', null),
            'port' => env('REDIS_PORT_ROMANIA', 6379),
            'database' => env('REDIS_CACHE_DB_ROMANIA', 1),
        ],

        'redis_croatia' => [
            'host' => env('REDIS_HOST_CROATIA', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD_CROATIA', null),
            'port' => env('REDIS_PORT_CROATIA', 6379),
            'database' => env('REDIS_CACHE_DB_CROATIA', 1),
        ],

        'redis_montenegro' => [
            'host' => env('REDIS_HOST_MONTENEGRO', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD_MONTENEGRO', null),
            'port' => env('REDIS_PORT_MONTENEGRO', 6379),
            'database' => env('REDIS_CACHE_DB_MONTENEGRO', 1),
        ],

        'redis_slovenia' => [
            'host' => env('REDIS_HOST_SLOVENIA', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD_SLOVENIA', null),
            'port' => env('REDIS_PORT_SLOVENIA', 6379),
            'database' => env('REDIS_CACHE_DB_SLOVENIA', 1),
        ],

        'redis_czech' => [
            'host' => env('REDIS_HOST_CZECH', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD_CZECH', null),
            'port' => env('REDIS_PORT_CZECH', 6379),
            'database' => env('REDIS_CACHE_DB_CZECH', 1),
        ],

        'redis_switzerland' => [
            'host' => env('REDIS_HOST_SWITZERLAND', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD_SWITZERLAND', null),
            'port' => env('REDIS_PORT_SWITZERLAND', 6379),
            'database' => env('REDIS_CACHE_DB_SWITZERLAND', 1),
        ],

        'redis_denmark' => [
            'host' => env('REDIS_HOST_DENMARK', '127.0.0.1'),
            'port' => env('REDIS_PORT_DENMARK', 6379),
            'password' => env('REDIS_PASSWORD_DENMARK', null),
            'database' => env('REDIS_CACHE_DB_DENMARK', 1),
        ],

        'redis_luxembourg' => [
            'host' => env('REDIS_HOST_LUXEMBOURG', '127.0.0.1'),
            'port' => env('REDIS_PORT_LUXEMBOURG', 6379),
            'password' => env('REDIS_PASSWORD_LUXEMBOURG', null),
            'database' => env('REDIS_CACHE_DB_LUXEMBOURG', 1),
        ],

        'redis_malaysia' => [
            'host' => env('REDIS_HOST_MALAYSIA', '127.0.0.1'),
            'port' => env('REDIS_PORT_MALAYSIA', 6379),
            'password' => env('REDIS_PASSWORD_MALAYSIA', null),
            'database' => env('REDIS_CACHE_DB_MALAYSIA', 1),
        ],

    ],

];

<?php

$tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 182.23.51.254)(PORT = 15211))
        (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = DBPDAM)))';
return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', $tnsname),
        'host'           => env('DB_HOST', '182.23.51.254'),
        'port'           => env('DB_PORT', '15211'),
        'database'       => env('DB_DATABASE', 'epdam'),
        'username'       => env('DB_USERNAME', 'epdam'),
        'password'       => env('DB_PASSWORD', 'epdam'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];

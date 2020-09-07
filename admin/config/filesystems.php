<?php

$cardsPath = explode("admin", storage_path())[0] . 'public\images\cards';

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */    

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root'   => storage_path('app'),
        ],
        
        'media' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/media'),
            'url'        => env('APP_URL') . '/storage/media',
            'visibility' => 'public',
        ],

        'public' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'url'        => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key'    => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

        'categories' =>[
            'driver'     => 'local',
            'root'       => storage_path('app/public/images/categories'),
            'url'        => env('APP_URL') . '/storage/images/categories',
            'visibility' => 'public',
        ],

        'cards' =>[
            'driver'     => 'local',
            'root'       => storage_path('app/public/images/cards'),
            'url'        => env('APP_URL') . '/storage/images/cards',
            'visibility' => 'public',
        ],

        'test_bg' =>[
            'driver'     => 'local',
            'root'       => storage_path('app/public/images/tests'),
            'url'        => env('APP_URL') . '/storage/images/tests',
            'visibility' => 'public',
        ],

        'results' =>[
            'driver'     => 'local',
            'root'       => storage_path('app/public/images/results'),
            'url'        => env('APP_URL') . '/storage/images/results',
            'visibility' => 'public',
        ],

        'questions' =>[
            'driver'     => 'local',
            'root'       => storage_path('app/public/images/questions'),
            'url'        => env('APP_URL') . '/storage/images/questions',
            'visibility' => 'public',
        ],

        /*'cards' =>[
            'driver' => 'local',
            'root'   => $cardsPath,
        ],*/


        /*'test_bg' =>[
            'driver' => 'local',
            'root'   => env('IMG_BG_URL'),
        ],*/

        'uploads' => [
            'driver' => 'local',
            'root' => public_path('uploads'),
        ],

        'uploads_test' => [
            'driver' => 'local',
            'root' => public_path('uploads/test')
        ],

    ],

];

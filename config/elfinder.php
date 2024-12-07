<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Upload dir
    |--------------------------------------------------------------------------
    |
    | The dir where to store the images (relative from public).
    |
    */
    'dir' => ['uploads'],

    /*
    |--------------------------------------------------------------------------
    | Filesystem disks (Flysytem)
    |--------------------------------------------------------------------------
    |
    | Define an array of Filesystem disks, which use Flysystem.
    | You can set extra options, example:
    |
    | 'my-disk' => [
    |        'URL' => url('to/disk'),
    |        'alias' => 'Local storage',
    |    ]
    */
    'disks' => [
        'public',
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes group config
    |--------------------------------------------------------------------------
    |
    | The default group settings for the elFinder routes.
    |
    */

    'route' => [
        'prefix'     => config('backpack.base.route_prefix', 'admin').'/elfinder',
        'middleware' => ['web', config('backpack.base.middleware_key', 'admin')], //Set to null to disable middleware filter
    ],

    /*
    |--------------------------------------------------------------------------
    | Access filter
    |--------------------------------------------------------------------------
    |
    | Filter callback to check the files
    |
    */

    'access' => 'Barryvdh\Elfinder\Elfinder::checkAccess',

    /*
    |--------------------------------------------------------------------------
    | Roots
    |--------------------------------------------------------------------------
    |
    | By default, the roots file is LocalFileSystem, with the above public dir.
    | If you want custom options, you can set your own roots below.
    |
    */

    'roots' => array(
        /*'accessControl' => 'access'  ,
        'uploadAllow' => array('image'),
        'uploadOrder'=> array( 'allow', 'deny' )*/
    ),

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    | These options are merged, together with 'roots' and passed to the Connector.
    | See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1
    |
    */

    'options' => [
        /*'uploadAllow' => array('image'),
        'uploadOrder'=> array( 'allow', 'deny' )*/
    ],


    /*
    |--------------------------------------------------------------------------
    | Root Options
    |--------------------------------------------------------------------------
    |
    | These options are merged, together with every root by default.
    | See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1#root-options
    |
    */
    'root_options' => array(
        'uploadAllow' => array(
            'image/png',
            'image/jpg',
            'image/jpeg',
            'application/msword',
            'application/excel',
            'application/x-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/x-zip-compressed',
            'application/zip', 'multipart/x-zip'
        ),
        'uploadDeny' => array(
            'all'
        ),
        'uploadOrder'=> array('deny', 'allow'),
    )
];

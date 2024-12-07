<?php

use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily'],
            'ignore_exceptions' => false,
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],

        'automation' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/automation.log'),
            'level' => 'info',
        ],

        'access' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/access/access.log'),
            'level' => 'info',
        ],

        'xemail' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/emails/email.log'),
            'level' => 'info',
        ],

        'contactus' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/contactus/email.log'),
            'level' => 'info',
        ],

        'forward-order' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/forward-order/forward-order.log'),
            'level' => 'info',
        ],

        'principal_claim' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/principal_claim/principal_claim.log'),
            'level' => 'info',
        ],

        'email-spool' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/email-spool/email-spool.log'),
            'level' => 'info',
        ],

        'claim_third_party' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/claim_third_party/claim_third_party.log'),
            'level' => 'info',
        ],

        'part_number' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/part_number/part_number.log'),
            'level' => 'info',
        ],

        'pipeline' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/pipeline/pipeline.log'),
            'level' => 'info',
        ],

        'huawei' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/huawei/huawei.log'),
            'level' => 'info',
        ],

        'sap' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/sap/sap.log'),
            'level' => 'info',
        ],

        'price_inquiry' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/price_inquiry/price_inquiry.log'),
            'level' => 'info',
        ],

        'support_ticket' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/support_ticket/support_ticket.log'),
            'level' => 'info',
        ],

        'ews_service' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/ews_service/ews_service.log'),
            'level' => 'info',
        ],

        'forecast_header' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/forecast_header/forecast_header.log'),
            'level' => 'info',
        ],

        'std_quotation' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/std_quotation/std_quotation.log'),
            'level' => 'info',
        ],

        'asset' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/asset/asset.log'),
            'level' => 'info',
        ],

        'rent_stock' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/rent_stock/rent_stock.log'),
            'level' => 'info',
        ],

        'engineering' => [
            'driver' => 'daily',
            'channels' => ['daily'],
            'path' => storage_path('logs/engineering/engineering.log'),
            'level' => 'info',
        ],
    ],

];

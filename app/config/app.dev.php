<?php
return [
    'debug' => true,
    'intl.default_locale' => 'en-EN',
    'date.timezone' => 'Europe/London',
    'db.options' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'db_name' => 'db_test'
    ],
    'twig' => [
        'twig.path' => ['%ROOT_PATH%/app/templates/'],
        'twig.options' => [
            'debug' => true,
            'auto_reload' => true,
            'cache' => '%ROOT_PATH%/app/cache/twig'
        ],
    ],
    'monolog' => [
        'monolog.logfile' => '%ROOT_PATH%/app/logs/application.log',
        'monolog.level' => \Monolog\Logger::DEBUG,
        'monolog.name' => 'application'
    ],
];
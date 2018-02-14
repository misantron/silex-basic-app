<?php
return [
    'debug' => false,
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
            'debug' => false,
            'cache' => '%ROOT_PATH%/app/cache/twig'
        ],
    ],
    'monolog' => [
        'monolog.logfile' => '%ROOT_PATH%/app/logs/application.log',
        'monolog.level' => \Monolog\Logger::ERROR,
        'monolog.name' => 'application'
    ],
];
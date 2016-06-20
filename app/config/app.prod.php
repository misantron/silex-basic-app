<?php
return [
    'debug' => false,
    'intl.default_locale' => 'en-EN',
    'date.timezone' => 'Europe/London',
    'doctrine.config' => [
        'db.options' => [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'user' => 'root',
            'password' => '',
            'db_name' => 'db_test'
        ]
    ],
    'db.migrations.namespace' => 'App\Migration',
    'db.migrations.name' => 'Application migrations',
    'db.migrations.path' => '%ROOT_PATH%/app/migrations',
    'db.migrations.table_name' => 'migration_versions',
    'twig.config' => [
        'twig.path' => ['%ROOT_PATH%/app/templates'],
        'twig.options' => [
            'debug' => false,
            'cache' => '%ROOT_PATH%/app/cache/twig'
        ],
    ],
    'monolog.config' => [
        'monolog.logfile' => '%ROOT_PATH%/app/logs/application.log',
        'monolog.level' => \Monolog\Logger::ERROR,
        'monolog.name' => 'application'
    ],
];
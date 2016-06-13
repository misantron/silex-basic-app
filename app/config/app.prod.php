<?php
return [
    'debug' => false,
    'log.level' => \Monolog\Logger::ERROR,
    'intl.default_locale' => 'en-EN',
    'date.timezone' => 'Europe/London',
    'db.options' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'db_name' => 'db_test'
    ],
    'db.migrations.namespace' => 'App\Migration',
    'db.migrations.name' => 'Application migrations',
    'db.migrations.path' => __DIR__ . '/../migrations',
    'db.migrations.table_name' => 'migration_versions',
];
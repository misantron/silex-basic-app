<?php
return [
    'debug' => true,
    'log.level' => \Monolog\Logger::DEBUG,
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
    'db.migrations.path' => '%root_path%/app/migrations',
    'db.migrations.table_name' => 'migration_versions',
];
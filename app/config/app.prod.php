<?php
return [
    'debug' => false,
    'intl.default_locale' => '',
    'date.timezone' => '',
    'db' => [

    ],
    'db.migrations' => [
        'path' => __DIR__ . '/../app/migrations',
        'table_name' => 'migrations',
    ],
    'providers' => [
        'vendor' => [
            'Silex\\Provider\\ServiceControllerServiceProvider',
            'Silex\\Provider\\TwigServiceProvider',
        ],
        'app' => [
            'App\\Provider\\Controller\\AppControllerProvider',
            'App\\Provider\\Service\\MigrationServiceProvider',
        ],
    ],
];
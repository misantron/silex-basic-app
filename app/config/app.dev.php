<?php
return [
    'debug' => true,
    'intl.default_locale' => '',
    'date.timezone' => '',
    'db' => [

    ],
    'db.migrations' => [
        'path' => __DIR__ . '/../app/migrations',
        'table_name' => 'migrations',
    ],
    'console.name' => 'Application console',
    'console.version' => '1.0.0',
    'providers' => [
        'vendor' => [
            \Silex\Provider\ServiceControllerServiceProvider::class,
            'Silex\\Provider\\TwigServiceProvider',
        ],
        'app' => [
            \App\Provider\Controller\AppControllerProvider::class,
            \App\Base\Provider\Service\ConsoleServiceProvider::class,
        ],
    ],
];
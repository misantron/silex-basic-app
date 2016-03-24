<?php
return [
    'debug' => true,
    'intl.default_locale' => '',
    'date.timezone' => '',
    'db' => [

    ],
    'db.migrations' => [

    ],
    'providers' => [
        'vendor' => [
            'Silex\Provider\ServiceControllerServiceProvider',
            'Silex\Provider\TwigServiceProvider',
        ],
        'app' => [
            'App\Provider\Controller\AppControllerProvider',
        ],
    ],
];
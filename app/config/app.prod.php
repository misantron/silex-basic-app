<?php
return [
    'debug' => false,
    'intl.default_locale' => '',
    'date.timezone' => '',
    'db.options' => [

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
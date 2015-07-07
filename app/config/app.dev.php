<?php
return [
    'debug' => true,
    'intl.default_locale' => '',
    'date.timezone' => '',
    'db.options' => [

    ],
    'vendor.providers' => [
        'Silex\Provider\ServiceControllerServiceProvider',
        'Silex\Provider\TwigServiceProvider',
        'Silex\Provider\DoctrineServiceProvider',
    ],
    'app.providers' => [
        'App\Provider\AppControllerProvider',
    ]
];
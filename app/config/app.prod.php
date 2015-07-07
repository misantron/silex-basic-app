<?php
return [
    'vendor.providers' => [
        'Silex\Provider\ServiceControllerServiceProvider',
        'Silex\Provider\TwigServiceProvider',
        'Silex\Provider\DoctrineServiceProvider',
    ],
    'app.providers' => [
        'App\Provider\AppControllerProvider',
    ]
];
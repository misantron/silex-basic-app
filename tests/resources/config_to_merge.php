<?php
return [
    'debug' => true,
    'date.timezone' => 'Europe/London',
    'cache.local' => [
        'path' => '%root_path%/cache',
        'lifetime' => '%lifetime%',
    ],
    'cache' => [
        'memcache' => [
            'host' => '127.0.0.1',
            'port' => 11211,
        ],
    ]
];
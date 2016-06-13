<?php
return [
    'debug' => true,
    'date.timezone' => 'Europe/London',
    '%prefix%' => 'test',
    'cache' => [
        'local' => [
            'path' => '%root_path%/cache',
            'lifetime' => '%lifetime%',
        ]
    ]
];
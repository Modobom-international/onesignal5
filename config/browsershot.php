<?php

return [
    'executable_path' => env('BROWSERSHOT_BINARY', '/usr/bin/google-chrome'),
    'default_options' => [
        'args' => ['--no-sandbox'],
        'viewport' => [
            'width' => 800,
            'height' => 600,
        ],
        'waitUntil' => 'networkidle0',
    ],
];

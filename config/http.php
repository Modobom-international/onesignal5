<?php
return [
    'middleware' => [
        'web' => [],

        'api' => [
            \App\Http\Middleware\ExcludeDomains::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ],
];

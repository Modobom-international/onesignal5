<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            \App\Http\Middleware\CorsMiddleware::class,
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        ]);

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class
        ]);

        $middleware->validateCsrfTokens(except: [
            '/save-html-source',
            '/push-system',
            '/push-system-config',
            '/add-user-active-push-system',
            '/push-system-global/save',
            '/push-system-global/add-user-active-push-system-global',
            '/create-log-behavior',
            'horizon/*',
            '/create-users-tracking'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

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
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\SetLocale::class,
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
            'roles' => \App\Http\Middleware\CheckRole::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'Html' => Spatie\Html\Facades\Html::class,
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

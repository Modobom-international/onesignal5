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
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
            'roles' => \App\Http\Middleware\CheckRole::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'Html' => Spatie\Html\Facades\Html::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            '/count-open-app',
            '/admin/config-keyword',
            '/admin/config-keyword*',
            '/config-keyword-post',
            '/captcha/generate*',
            '/log-phones',
            '/save-html-source',
            '/eu/check-device-exist',
            '/admin/apk/upload-amazon-post',
            '/test-post',
            '/log-message-eu',
            '/download/get-url',
            '/add-player-id',
            '/add-player-id-lock',
            '/add-onesignal-sms-info',
            '/save-tiktok-tracking',
            '/create-user-social',
            '/update-user-social',
            '/create-sms-otp',
            '/store-storage-sim',
            '/create-sms-otp-storage-sim',
            '/update-history-sim',
            '/create-file',
            '/push-system',
            '/push-system-config',
            '/add-user-active-push-system',
            '/config-link/save',
            '/link/save',
            '/tracking/save-click-ajax',
            '/api/update-link-checking-status',
            '/push-system-global/save',
            '/push-system-global/add-user-active-push-system-global',
            '/wap-url/save-wap-info',
            '/create-log-behavior',
            'horizon/*',
            '/create-users-tracking'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

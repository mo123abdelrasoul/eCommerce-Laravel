<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
            \App\Http\Middleware\LanguageMiddleware::class,
        ]);
        // Register middleware aliases
        $middleware->alias([
            'checkUserRole' => \App\Http\Middleware\CheckUserRole::class,
            'setLocale' => \App\Http\Middleware\LanguageMiddleware::class,
            'check.admin.permission' => \App\Http\Middleware\CheckAdminPermission::class,
            'check.vendor.permission' => \App\Http\Middleware\CheckVendorPermission::class,
            'check.customer.permission' => \App\Http\Middleware\CheckCustomerPermission::class,
        ]);
        $middleware->group('web', [
            \Illuminate\Session\Middleware\StartSession::class,
            \App\Http\Middleware\LanguageMiddleware::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

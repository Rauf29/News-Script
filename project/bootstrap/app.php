<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->replace(
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\VerifyCsrfToken::class
        );

        $middleware->replace(
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \App\Http\Middleware\TrimStrings::class
        );

        $middleware->replace(
            \Illuminate\Http\Middleware\TrustProxies::class,
            \App\Http\Middleware\TrustProxies::class
        );

        $middleware->alias([
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'admininistrator' => \App\Http\Middleware\Administrator::class,
            'vendor' => \App\Http\Middleware\Vendor::class,
            'permissions' => \App\Http\Middleware\Permissions::class,
            'maintenance' => \App\Http\Middleware\MaintenanceMode::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->dontFlash([
            'password',
            'password_confirmation',
        ]);

    })
    ->create()
    ->usePublicPath(realpath(__DIR__.'/../../'))
    ->useEnvironmentPath(realpath(__DIR__.'/../vendor/markury/src/'));

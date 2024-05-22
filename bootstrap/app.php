<?php

use App\Exceptions\PermissionAlreadyExists;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            \App\Http\Middleware\AddRequestPerPage::class
        ]);

        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \App\Http\Middleware\RoleOrPermissionMiddleware::class,
            'per_page' => \App\Http\Middleware\AddRequestPerPage::class
        ]);

        $middleware->statefulApi();

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (PermissionAlreadyExists $e){
            return false;
        });
    })->create();

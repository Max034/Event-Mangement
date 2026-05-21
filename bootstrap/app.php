<?php

// Polyfill for SortDirection enum missing in older Laravel versions, required by mongodb/laravel-mongodb package
if (!enum_exists('SortDirection')) {
    eval('enum SortDirection { case Ascending; case Descending; }');
}
if (!enum_exists('Illuminate\Database\Query\SortDirection')) {
    eval('namespace Illuminate\Database\Query; enum SortDirection { case Ascending; case Descending; }');
}

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

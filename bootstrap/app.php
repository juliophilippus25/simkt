<?php

use App\Http\Middleware\AccessControl;
use App\Http\Middleware\RedirectIfAuthtenticated;
use App\Http\Middleware\RedirectIfNotAuthtenticated;
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
        $middleware->alias([
            'redirectIfAuthtenticated' => RedirectIfAuthtenticated::class,
            'redirectIfNotAuthtenticated' => RedirectIfNotAuthtenticated::class,
            'accessControl' => AccessControl::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

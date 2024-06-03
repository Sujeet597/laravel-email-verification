<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\ApiKeyMiddleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use  Illuminate\Routing\Middleware\SubstituteBindings;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'todo/add',
           'todo/status',
           '/login',
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(ApiKeyMiddleware::class);
   })
   ->withMiddleware(function (Middleware $middleware) {
    $middleware->append(EnsureFrontendRequestsAreStateful::class);
})



    ->withMiddleware(function (Middleware $middleware) {
        //

    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

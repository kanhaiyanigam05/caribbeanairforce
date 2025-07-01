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
        $middleware->redirectTo(
            guests: 'admin/login',
            users: 'admin/dashboard'
        );
        $middleware->alias([
            'verify.documents' => \App\Http\Middleware\VerifyDocuments::class,
            'role.redirect' => \App\Http\Middleware\RoleBasedRedirect::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\SetUserTimezone::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

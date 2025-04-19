<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\App\Http\Middleware\ForceJsonResponse::class);
        $middleware->alias([
            'permission'        => \App\Http\Middleware\PermissionMiddleware::class,
            'auth.token_expiry' => \App\Http\Middleware\CheckTokenExpiry::class,
            'admin'             => \App\Http\Middleware\AdminMiddleware::class,
            'set.language'      => \App\Http\Middleware\SetLanguage::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            return response()->json([
                'message' => 'You do not have the required permissions.',
            ], 403);
        });

        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        });
    })
    ->create();

<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Health check endpoint — registered OUTSIDE web middleware group
            // No sessions, no cookies, no CSRF, no encryption — just raw response
            // This ensures /health works even before migrations run
            Route::get('/health', function () {
                try {
                    \Illuminate\Support\Facades\DB::connection()->getPdo();
                    return response()->json([
                        'status' => 'ok',
                        'database' => 'connected',
                        'timestamp' => now()->toIso8601String(),
                        'environment' => app()->environment(),
                    ]);
                } catch (\Exception $e) {
                    // Return 200 even if DB isn't ready — app is running
                    // Migrations may still be in progress
                    return response()->json([
                        'status' => 'ok',
                        'database' => 'pending',
                        'message' => 'App running, migrations may still be in progress',
                        'timestamp' => now()->toIso8601String(),
                    ]);
                }
            });
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

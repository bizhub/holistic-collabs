<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Domain\Clinic\Middleware\IsValidClinic;
use Domain\User\Middleware\IsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function () {
            Route::prefix('ext')
                ->middleware('api')
                ->name('ext.')
                ->group(base_path('routes/external.php'));

            Route::middleware(['web', 'auth', 'admin'])
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            Route::prefix('clinic')
                ->middleware(['web', 'auth', 'clinic'])
                ->name('clinic.')
                ->group(base_path('routes/clinic.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'admin' => IsAdmin::class,
            'clinic' => IsValidClinic::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

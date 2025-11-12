<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['web', 'auth'])
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Confiar en los proxies (Render/Cloudflare) para respetar X-Forwarded-*
        $middleware->trustProxies(at: '*');

        // (Opcional) Si quieres restringir hosts de confianza:
        // $middleware->trustHosts(at: ['^inventario-oc73\.onrender\.com$']);
    })
    ->withBooting(function (): void {
        // Forzar https en producción para que URLs y <form action> usen https
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
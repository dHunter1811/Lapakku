<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; // Pastikan ini ada
use App\Http\Middleware\AdminMiddleware; // 1. Tambahkan use statement untuk middleware Anda

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 2. Daftarkan route middleware Anda di sini
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            // Tambahkan alias middleware lain jika perlu
            // 'auth' => \App\Http\Middleware\Authenticate::class, // Contoh bawaan
        ]);

        // Anda juga bisa mendaftarkan middleware global di sini, misalnya:
        // $middleware->append(SomeGlobalMiddleware::class);
        // $middleware->prepend(AnotherGlobalMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
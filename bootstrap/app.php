<?php

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
        
        // 🚀 TRUST NGROK PROXY
        $middleware->trustProxies(at: '*');
        
        // 🚀 TAMBAHKAN ALIAS MIDDLEWARE DI SINI GUS!
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class, // (Asumsi ini sudah ada sebelumnya)
            'cek.kelas' => \App\Http\Middleware\CekKelasAktif::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
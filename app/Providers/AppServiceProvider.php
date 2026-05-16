<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 🚀 ROBUST NGROK DETECTION (BEKERJA DI SEMUA KONDISI)
        
        // Cek 1: X-Forwarded-Proto header (Ngrok standard)
        $proto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? $_SERVER['REQUEST_SCHEME'] ?? 'http';
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? 'localhost';
        
        // Cek 2: Apakah ngrok?
        $isNgrok = str_contains($host, 'ngrok');
        
        // Cek 3: Setup URL & Session Security
        if ($isNgrok || $proto === 'https') {
            // HTTPS (Ngrok)
            $appUrl = 'https://' . $host;
            URL::forceScheme('https');
            config(['session.secure' => false]); // Allow HTTPS cookie (Ngrok issue)
            config(['session.same_site' => 'none']); // Cross-site cookie
        } else {
            // HTTP (Local)
            $appUrl = 'http://' . $host;
            URL::forceScheme('http');
            config(['session.secure' => false]);
            config(['session.same_site' => 'lax']);
        }
        
        // Force app.url agar konsisten di seluruh aplikasi
        config(['app.url' => $appUrl]);
        URL::forceRootUrl($appUrl);
    }
}
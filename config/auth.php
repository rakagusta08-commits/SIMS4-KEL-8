<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Authentication Driver
    |--------------------------------------------------------------------------
    |
    | Ini menentukan siapa yang login secara default. Kita set ke 'web' (User biasa)
    | atau bisa diganti nanti sesuai kebutuhan.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards (DAFTAR SATPAM)
    |--------------------------------------------------------------------------
    |
    | Di sini kita mendaftarkan Satpam untuk Guru dan Siswa.
    | Driver 'session' artinya loginnya disimpan di browser (cookie).
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // SATPAM GURU
        'guru' => [
            'driver' => 'session',
            'provider' => 'gurus',
        ],

        // SATPAM SISWA
        'siswa' => [
            'driver' => 'session',
            'provider' => 'siswas',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers (SUMBER DATA PENGGUNA)
    |--------------------------------------------------------------------------
    |
    | Di sini kita kasih tahu Laravel di mana tabel data penggunanya berada.
    | Pastikan model App\Models\Guru dan Siswa sudah ada.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // DATA GURU (Menyambung ke Model Guru)
        'gurus' => [
            'driver' => 'eloquent',
            'model' => App\Models\Guru::class,
        ],

        // DATA SISWA (Menyambung ke Model Siswa)
        'siswas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Siswa::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Pengaturan untuk fitur "Lupa Password".
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        // Kita tambahkan juga untuk guru/siswa jaga-jaga nanti butuh reset password
        'gurus' => [
            'provider' => 'gurus',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'siswas' => [
            'provider' => 'siswas',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */

    'password_timeout' => 10800,

];
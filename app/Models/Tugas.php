<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    // 1. Menentukan nama tabel di database
    protected $table = 'tugas';

    // 2. Kolom yang diizinkan untuk diisi secara massal
    // PERBAIKAN: Menggunakan 'judul_tugas' sesuai kolom di phpMyAdmin kamu
    protected $fillable = [
        'mapel',
        'judul_tugas',
        'deskripsi',
        'kelas',
        'deadline'
    ];

    /**
     * 3. Konversi tipe data otomatis (Casts)
     * Ini supaya kolom deadline otomatis jadi format tanggal
     */
    protected $casts = [
        'deadline' => 'date',
    ];
}
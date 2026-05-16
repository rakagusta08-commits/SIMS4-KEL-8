<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'absensis';

    // Kolom yang boleh diisi (WAJIB ADA)
    protected $fillable = [
        'nis',
        'kelas_id',
        'tanggal',
        'status',
        'keterangan',
        'qr_code',
        'qr_generated_at'
    ];

    // Casting kolom ke tipe data (PENTING untuk translatedFormat)
    protected $casts = [
        'tanggal' => 'date',
        'qr_generated_at' => 'datetime',
    ];

    /**
     * Relasi ke Siswa
     * (Supaya kita bisa tau absen ini milik siswa siapa)
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    /**
     * Relasi ke Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
}
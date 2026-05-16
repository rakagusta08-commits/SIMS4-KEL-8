<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';
    protected $guarded = []; // Mengizinkan semua kolom diisi

    // Relasi ke Tugas
    public function tugas() {
        return $this->belongsTo(Tugas::class, 'tugas_id', 'id');
    }

    // Relasi ke Siswa
    public function siswa() {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }
}
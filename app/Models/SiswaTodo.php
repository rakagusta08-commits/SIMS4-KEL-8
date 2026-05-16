<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaTodo extends Model
{
    use HasFactory;

    protected $table = 'siswa_todos';

    protected $fillable = [
        'nis',
        'judul_tugas',
        'deskripsi',
        'prioritas',
        'deadline',
        'sudah_selesai',
        'selesai_pada'
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'selesai_pada' => 'datetime',
        'sudah_selesai' => 'boolean'
    ];

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    // Scope untuk menampilkan tugas yang belum selesai
    public function scopePending($query)
    {
        return $query->where('sudah_selesai', false)->orderBy('prioritas', 'desc')->orderBy('deadline', 'asc');
    }

    // Scope untuk menampilkan tugas yang sudah selesai
    public function scopeCompleted($query)
    {
        return $query->where('sudah_selesai', true)->latest('selesai_pada');
    }
}

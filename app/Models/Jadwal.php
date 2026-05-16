<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals';
    
    // TAMBAHKAN BARIS INI (Matikan fitur timestamps otomatis)
    public $timestamps = false; 

    protected $fillable = [
        'hari', 
        'jam_mulai', 
        'jam_selesai', 
        'mata_pelajaran', 
        'kelas'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'mata_pelajaran', 'mata_pelajaran');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Siswa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'siswas'; 

    // Tidak boleh ada protected $primaryKey = 'nis'; di sini!
    // Biarkan Laravel pakai kolom 'id' bawaan tabel kamu.

    protected $fillable = [
        'nis',        
        'nama_siswa',
        'kelas',      
        'jenkel',     
        'jenis_kelamin',
        'alamat',     
        'no_hp',
        'tanggal_lahir',
        'tempat_lahir',
        'agama',
        'nama_ortu',
        'password',   
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }
}
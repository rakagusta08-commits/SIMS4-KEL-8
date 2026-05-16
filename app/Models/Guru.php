<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'gurus'; 
    protected $guard = 'guru';

    // Jika di database kamu kolom 'nip' memang Primary Key, biarkan ini.
 
    protected $fillable = [
        'nip', 
        'nama_guru', 
        'role', 
        'id_kelas_wali',
        'password', 
        'mata_pelajaran'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Beritahu Laravel kolom password namanya 'password'
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    // 💡 TIPS: Kita buat fungsi bantu untuk mengecek role di Blade nanti
    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function isWaliKelas() {
        return $this->role === 'wali_kelas';
    }

    public function isGuruMapel() {
        return $this->role === 'guru_mapel';
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
{
    // 1. Bikin Akun Guru (Admin)
    \App\Models\Guru::create([
        'nip' => '123456', // Username Login Guru
        'nama_guru' => 'Pak Budi Santoso',
        'password' => bcrypt('guru123'), // Password Login Guru
        'mata_pelajaran' => 'Produktif RPL',
    ]);

    // 2. Bikin Akun Guru Kedua (Raka Gustavo)
    \App\Models\Guru::create([
        'nip' => '6675974973', // Username Login Raka
        'nama_guru' => 'Raka Augusta (Gustavo)',
        'password' => bcrypt('raka123'), // Password Login Raka
        'mata_pelajaran' => 'Desain Grafis',
    ]);

    // 3. Bikin Akun Siswa
    // Akun Wanda
    \App\Models\Siswa::create([
        'nis' => '658454325', // Username Login Wanda
        'nama_siswa' => 'Wanda Nazra',
        'password' => bcrypt('wanda123'),
        'jenkel' => 'P',
        'alamat' => 'Jl. BKR, Bandung',
        'kelas' => '11 RPL',
    ]);
}
}

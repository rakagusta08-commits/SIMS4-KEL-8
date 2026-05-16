<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // 🚀 Daftar kolom biografi yang mau ditambah (sesuaikan kalau ada lainnya)
            $kolom_biografi = [
                'alamat'         => fn() => $table->string('alamat')->nullable(),
                'tanggal_lahir'  => fn() => $table->date('tanggal_lahir')->nullable(),
                'tempat_lahir'   => fn() => $table->string('tempat_lahir')->nullable(),
                'jenis_kelamin'  => fn() => $table->string('jenis_kelamin')->nullable(),
                'no_hp'          => fn() => $table->string('no_hp')->nullable(),
                'agama'          => fn() => $table->string('agama')->nullable(),
                'nama_ortu'      => fn() => $table->string('nama_ortu')->nullable(),
                'foto'           => fn() => $table->string('foto')->nullable(),
            ];

            foreach ($kolom_biografi as $nama => $callback) {
                if (!Schema::hasColumn('siswas', $nama)) {
                    $callback();
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $kolom = ['alamat', 'tanggal_lahir', 'tempat_lahir', 'jenis_kelamin', 'no_hp', 'agama', 'nama_ortu', 'foto'];
            foreach ($kolom as $nama) {
                if (Schema::hasColumn('siswas', $nama)) {
                    $table->dropColumn($nama);
                }
            }
        });
    }
};
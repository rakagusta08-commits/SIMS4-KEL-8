<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('gurus', function (Blueprint $table) {
        // Kita tambah kolom role. Defaultnya 'guru_mapel'
        // Pilihannya nanti: admin, guru_mapel, wali_kelas
        $table->string('role')->default('guru_mapel')->after('nama_guru');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            //
        });
    }
};

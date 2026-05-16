<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tugas', function (Blueprint $table) {
            // Menambahkan kolom file_tugas yang boleh kosong (nullable)
            $table->string('file_tugas')->nullable()->after('deskripsi');
        });
    }

    public function down()
    {
        Schema::table('tugas', function (Blueprint $table) {
            // Untuk menghapus kolom jika kita membatalkan migration
            $table->dropColumn('file_tugas');
        });
    }
};
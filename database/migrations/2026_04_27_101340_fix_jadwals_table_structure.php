<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            // Tambah kolom kelas_id jika belum ada
            if (!Schema::hasColumn('jadwals', 'kelas_id')) {
                $table->unsignedBigInteger('kelas_id')->nullable()->after('id');
                $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            }
            
            // Tambah kolom guru_id jika belum ada
            if (!Schema::hasColumn('jadwals', 'guru_id')) {
                $table->unsignedBigInteger('guru_id')->nullable()->after('kelas_id');
                $table->foreign('guru_id')->references('id')->on('gurus')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
            $table->dropForeign(['guru_id']);
            $table->dropColumn('guru_id');
        });
    }
};
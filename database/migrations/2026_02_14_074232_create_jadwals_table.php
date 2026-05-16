<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
           $table->id();
        $table->string('hari');
        $table->string('jam_mulai');
        $table->string('jam_selesai');
        $table->string('mata_pelajaran');
        $table->string('kelas'); // Untuk membedakan jadwal 11 RPL 3 dsb
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};

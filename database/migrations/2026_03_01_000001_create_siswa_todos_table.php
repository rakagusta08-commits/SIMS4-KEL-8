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
        Schema::create('siswa_todos', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->string('judul_tugas');
            $table->text('deskripsi')->nullable();
            $table->enum('prioritas', ['Rendah', 'Sedang', 'Tinggi'])->default('Sedang');
            $table->datetime('deadline')->nullable();
            $table->boolean('sudah_selesai')->default(false);
            $table->datetime('selesai_pada')->nullable();
            $table->foreign('nis')->references('nis')->on('siswas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_todos');
    }
};

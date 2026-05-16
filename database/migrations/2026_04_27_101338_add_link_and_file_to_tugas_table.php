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
        Schema::table('tugas', function (Blueprint $table) {
            // Menambahkan kolom link dan file_lampiran setelah kolom deskripsi
            $table->string('link')->nullable()->after('deskripsi'); 
            $table->string('file_lampiran')->nullable()->after('link'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->dropColumn(['link', 'file_lampiran']);
        });
    }
};
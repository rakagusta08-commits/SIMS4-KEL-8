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
        Schema::table('siswas', function (Blueprint $table) {
            // Tambahkan kolom yang missing
            if (!Schema::hasColumn('siswas', 'biografi')) {
                $table->text('biografi')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'foto_profil')) {
                $table->string('foto_profil')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'no_telepon')) {
                $table->string('no_telepon')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'alamat')) {
                $table->text('alamat')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable();
            } 
            if (!Schema::hasColumn('siswas', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumnIfExists('biografi');
            $table->dropColumnIfExists('foto_profil');
            $table->dropColumnIfExists('no_telepon');
            $table->dropColumnIfExists('alamat');
            $table->dropColumnIfExists('tanggal_lahir');
            $table->dropColumnIfExists('jenis_kelamin');
        });
    }
};
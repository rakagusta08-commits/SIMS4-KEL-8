<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update jadwal dengan kelas_id = 4 (atau ID kelas yang paling banyak)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('jadwals')
            ->whereNull('kelas_id')
            ->update(['kelas_id' => 4]); // Ganti 4 dengan ID kelas yang ada
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
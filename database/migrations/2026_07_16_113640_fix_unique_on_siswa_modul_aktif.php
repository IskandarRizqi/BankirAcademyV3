<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('siswa_modul_aktif', function (Blueprint $table) {
            // 1. Hapus foreign key yang mengikat user_id terlebih dahulu
            $table->dropForeign(['user_id']);
            
            // 2. Sekarang kita bisa aman menghapus unique index yang lama
            $table->dropUnique(['user_id']); 
            
            // 3. Pasang kembali foreign key untuk user_id tanpa unique constraint tunggal
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // 4. Tambahkan unique constraint komposit baru (user_id + class_id)
            $table->unique(['user_id', 'class_id']); 
        });
    }

    public function down()
    {
        Schema::table('siswa_modul_aktif', function (Blueprint $table) {
            // Proses sebaliknya untuk rollback
            $table->dropUnique(['user_id', 'class_id']);
            
            $table->dropForeign(['user_id']);
            $table->unique('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
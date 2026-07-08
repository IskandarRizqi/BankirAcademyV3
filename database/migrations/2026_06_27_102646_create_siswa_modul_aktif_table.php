<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('siswa_modul_aktif', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (atau siswa)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Menghubungkan ke tabel materi/kelas
            $table->foreignId('class_id')->constrained('materi')->onDelete('cascade'); 
            $table->timestamps();

            // Memastikan di tingkat database satu user hanya punya maksimal 1 baris (1 modul aktif)
            $table->unique('user_id'); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('siswa_modul_aktif');
    }
};
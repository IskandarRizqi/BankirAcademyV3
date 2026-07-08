<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('history_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Sesuaikan nama tabel siswa Anda jika berbeda
            $table->foreignId('sub_materi_id');
            $table->timestamps();
            
            // Mencegah duplikasi history untuk siswa dan bab yang sama
            $table->unique(['user_id', 'sub_materi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('history_pelatihan');
    }
};

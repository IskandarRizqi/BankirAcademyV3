<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->double('harga');
            $table->double('diskon')->default(0);
            $table->double('harga_final');
            $table->integer('limit_siswa');
            $table->integer('limit_beasiswa');
            $table->date('masa_hingga');
            $table->text('gambar'); // Menyimpan path/nama file gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
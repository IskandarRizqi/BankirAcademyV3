<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_templates', function (Blueprint $bluePrint) {
            $bluePrint->id();
            // Menentukan tipe target template: 'materi' atau 'sub_materi'
            $bluePrint->enum('target_type', ['materi', 'sub_materi']);
            
            // ID Relasi opsional tergantung tipe targetnya
            $bluePrint->unsignedBigInteger('materi_id')->nullable();
            $bluePrint->unsignedBigInteger('sub_materi_id')->nullable();
            
            $bluePrint->string('background_image'); // Path file gambar template (contoh: 'certificates/template1.png')
            
            // Koordinat dinamis untuk penempatan teks nama user di sertifikat (dalam pixel atau persen)
            $bluePrint->integer('coordinate_x')->default(200);
            $bluePrint->integer('coordinate_y')->default(350);
            $bluePrint->integer('font_size')->default(40);
            
            $bluePrint->timestamps();
            $bluePrint->softDeletes();

            // Foreign Key Constraints
            $bluePrint->foreign('materi_id')->references('id')->on('materi')->onDelete('cascade');
            $bluePrint->foreign('sub_materi_id')->references('id')->on('sub_materi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_templates');
    }
};
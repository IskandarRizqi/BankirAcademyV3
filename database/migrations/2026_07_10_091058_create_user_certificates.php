<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_certificates', function (Blueprint $bluePrint) {
            $bluePrint->id();
            $bluePrint->unsignedBigInteger('user_id');
            $bluePrint->unsignedBigInteger('certificate_template_id');
            
            $bluePrint->string('certificate_code')->unique(); // Kode unik sertifikat (misal: SERTI/2026/001)
            $bluePrint->timestamp('issued_at')->useCurrent(); // Tanggal didapatkan
            
            $bluePrint->timestamps();

            // Foreign Key Constraints (Asumsi tabel user Anda bernama 'users')
            $bluePrint->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $bluePrint->foreign('certificate_template_id')->references('id')->on('certificate_templates')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_certificates');
    }
};
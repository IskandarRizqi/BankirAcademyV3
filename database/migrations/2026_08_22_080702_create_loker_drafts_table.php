<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loker_drafts', function (Blueprint $table) {
            $table->id();
            $table->enum('source_type', ['social_media', 'job_platform']);
            $table->string('platform')->nullable(); // e.g., LinkedIn, JobStreet, Instagram
            $table->string('sumber_url')->nullable();

            // Perusahaan & Detail
            $table->string('nama_perusahaan');
            $table->string('logo_url')->nullable();
            $table->string('email_perusahaan')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('instagram_dm')->nullable();
            $table->string('website_form_url')->nullable();

            // Lokasi (Raw string dari scraping)
            $table->text('alamat_raw')->nullable();
            $table->string('provinsi_raw')->nullable();

            // Informasi Pekerjaan
            $table->string('posisi');
            $table->text('deskripsi_pekerjaan')->nullable();
            $table->text('jobdesk')->nullable();
            $table->text('kualifikasi_jobspek')->nullable();
            $table->text('keahlian_skill')->nullable();
            $table->string('tipe_pekerjaan')->nullable(); // Fulltime, Parttime, dll.
            $table->string('kategori_bidang')->nullable();
            $table->text('fasilitas')->nullable();
            $table->text('cara_melamar')->nullable();

            // Gaji
            $table->string('gaji_raw')->nullable(); // String mentah hasil scraping
            $table->decimal('gaji_min', 12, 2)->nullable();
            $table->decimal('gaji_max', 12, 2)->nullable();

            // Ringkasan Tambahan (AI / metadata)
            $table->text('ringkasan_ai')->nullable();

            // Tanggal
            $table->timestamp('tanggal_posting')->nullable();
            $table->date('batas_pendaftaran')->nullable();

            // Status Approval Admin
            $table->enum('status_draft', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loker_drafts');
    }
};

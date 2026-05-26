<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penarikan_dana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('jumlah', 15, 2);
            $table->string('bank_tujuan');
            $table->string('nomor_rekening');
            $table->string('nama_pemilik_rekening'); // Tambahan standar untuk validasi bank
            $table->enum('status', ['pending', 'sukses', 'gagal'])->default('pending');
            $table->text('catatan_admin')->nullable(); // Untuk alasan jika penarikan ditolak/gagal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penarikan_dana');
    }
};
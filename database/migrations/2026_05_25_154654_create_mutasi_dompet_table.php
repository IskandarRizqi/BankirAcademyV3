<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mutasi_dompet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->decimal('jumlah', 15, 2);
            $table->string('tipe_aksi'); // Contoh: 'CASHBACK_KELAS', 'PENARIKAN_SALDO'
            $table->integer('class_id')->nullable();
            $table->integer('payment_id')->nullable();
            $table->unsignedBigInteger('referensi_id')->nullable(); // ID dari transaksi terkait
            $table->text('keterangan')->nullable();
            $table->timestamps(); // Menyediakan created_at sebagai waktu mutasi

            // Tambahkan index untuk optimasi performa query history
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_dompet');
    }
};
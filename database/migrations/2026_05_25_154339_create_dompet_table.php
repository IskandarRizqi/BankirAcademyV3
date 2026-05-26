<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dompet', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users, jika user dihapus maka dompet otomatis terhapus
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Saldo menggunakan decimal(15,2) artinya maksimal 999 triliun, dengan 2 angka di belakang koma
            $table->decimal('saldo', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dompet');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambahkan kolom baru (sesuaikan nama tabel jika berbeda)
        Schema::table('lamaran_models', function (Blueprint $table) {
            $table->string('tempat_lahir', 100)->nullable()->after('nama_panggilan');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
        });

        // 2. Migrasi Data Lama
        $kamusBulan = [
            'januari' => '01',
            'februari' => '02',
            'maret' => '03',
            'april' => '04',
            'mei' => '05',
            'juni' => '06',
            'juli' => '07',
            'agustus' => '08',
            'september' => '09',
            'oktober' => '10',
            'november' => '11',
            'desember' => '12'
        ];

        DB::table('lamaran_models')->whereNotNull('tmpttgllahir')->where('tmpttgllahir', '!=', '')->orderBy('id')->chunk(100, function ($lamarans) use ($kamusBulan) {
            foreach ($lamarans as $lamaran) {
                // Contoh format lama: "Jakarta, 24 november 2007"
                $parts = explode(',', $lamaran->tmpttgllahir);

                if (count($parts) >= 2) {
                    $tempat = trim($parts[0]);
                    $tanggalRaw = strtolower(trim($parts[1])); // "24 november 2007"

                    // Replace nama bulan indonesia menjadi angka
                    foreach ($kamusBulan as $nama => $angka) {
                        if (str_contains($tanggalRaw, $nama)) {
                            $tanggalRaw = str_replace($nama, $angka, $tanggalRaw);
                            break;
                        }
                    }

                    try {
                        // Ubah "24 11 2007" menjadi "2007-11-24"
                        $tanggalDate = Carbon::createFromFormat('d m Y', $tanggalRaw)->format('Y-m-d');

                        DB::table('lamarans')->where('id', $lamaran->id)->update([
                            'tempat_lahir' => $tempat,
                            'tanggal_lahir' => $tanggalDate
                        ]);
                    } catch (\Exception $e) {
                        // Lewati jika format tanggal berantakan dan tidak bisa di-parse
                        continue;
                    }
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('lamaran_models', function (Blueprint $table) {
            $table->dropColumn(['tempat_lahir', 'tanggal_lahir']);
        });
    }
};

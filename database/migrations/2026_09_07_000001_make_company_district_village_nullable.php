<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE `perusahaan_models` MODIFY `kecamatan` TEXT NULL, MODIFY `kelurahan` TEXT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE `perusahaan_models` MODIFY `kecamatan` TEXT NOT NULL, MODIFY `kelurahan` TEXT NOT NULL');
    }
};

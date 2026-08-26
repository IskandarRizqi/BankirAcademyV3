<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loker_drafts', function (Blueprint $table) {
            $table->integer('provinsi_id')->nullable()->after('provinsi_raw');
            $table->integer('kabupaten_id')->nullable()->after('provinsi_id');
            $table->integer('kecamatan_id')->nullable()->after('kabupaten_id');
            $table->integer('kelurahan_id')->nullable()->after('kecamatan_id');
            $table->foreignId('published_loker_id')->nullable()->after('approved_by')
                ->constrained('loker')->nullOnDelete();
            $table->foreignId('published_perusahaan_id')->nullable()->after('published_loker_id')
                ->constrained('perusahaan_models')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('loker_drafts', function (Blueprint $table) {
            $table->dropForeign(['published_loker_id']);
            $table->dropForeign(['published_perusahaan_id']);
            $table->dropColumn([
                'provinsi_id',
                'kabupaten_id',
                'kecamatan_id',
                'kelurahan_id',
                'published_loker_id',
                'published_perusahaan_id',
            ]);
        });
    }
};

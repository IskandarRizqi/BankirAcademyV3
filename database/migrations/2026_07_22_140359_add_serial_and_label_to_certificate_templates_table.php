<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('certificate_templates', function (Blueprint $table) {
            // Menambahkan kolom koordinat Y & font size untuk No. Seri dan Teks Label
            $table->integer('serial_y')->nullable()->default(330)->after('font_size');
            $table->integer('serial_font_size')->nullable()->default(18)->after('serial_y');
            $table->integer('label_y')->nullable()->default(390)->after('serial_font_size');
            $table->integer('label_font_size')->nullable()->default(16)->after('label_y');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificate_templates', function (Blueprint $table) {
            // Drop kolom jika migration di-rollback
            $table->dropColumn([
                'serial_y',
                'serial_font_size',
                'label_y',
                'label_font_size'
            ]);
        });
    }
};
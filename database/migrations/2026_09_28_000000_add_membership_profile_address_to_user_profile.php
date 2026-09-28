<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('user_profile', 'phone') && DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE user_profile MODIFY phone VARCHAR(30) NOT NULL');
        }

        Schema::table('user_profile', function (Blueprint $table) {
            if (! Schema::hasColumn('user_profile', 'alamat')) {
                $table->text('alamat')->nullable();
            }
            if (! Schema::hasColumn('user_profile', 'provinsi_id')) {
                $table->unsignedInteger('provinsi_id')->nullable();
            }
            if (! Schema::hasColumn('user_profile', 'kota_id')) {
                $table->unsignedInteger('kota_id')->nullable();
            }
            if (! Schema::hasColumn('user_profile', 'kecamatan_id')) {
                $table->unsignedInteger('kecamatan_id')->nullable();
            }
            if (! Schema::hasColumn('user_profile', 'kelurahan_id')) {
                $table->unsignedInteger('kelurahan_id')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_profile', function (Blueprint $table) {
            foreach (['alamat', 'provinsi_id', 'kota_id', 'kecamatan_id', 'kelurahan_id'] as $column) {
                if (Schema::hasColumn('user_profile', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        if (Schema::hasColumn('user_profile', 'phone') && DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE user_profile MODIFY phone INT NOT NULL');
        }
    }
};

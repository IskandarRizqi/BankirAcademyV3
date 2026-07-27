<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_materi', function (Blueprint $table) {
            // Menambahkan kolom thumbnail setelah kolom keterangan (nullable karena tidak semua materi punya thumbnail)
            $table->string('thumbnail')->nullable()->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_materi', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn('thumbnail');
        });
    }
};
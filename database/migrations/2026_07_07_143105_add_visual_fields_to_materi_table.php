<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->string('banner')->nullable()->after('keterangan');
            $table->string('icon')->nullable()->default('fas fa-graduation-cap')->after('banner');
            $table->integer('jumlah_peserta')->default(0)->after('icon');
        });
    }

    public function down()
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->dropColumn(['banner', 'icon', 'jumlah_peserta']);
        });
    }
};
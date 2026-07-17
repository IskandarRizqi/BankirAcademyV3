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
        Schema::table('datapayment', function (Blueprint $table) {
            $table->integer('is_konfirmasi')->default(1)->comment('0 not konfirmasi 1 konfirmasi')->after('tipe_pembelian');
            $table->integer('is_iht')->default(0)->comment('1 true 0 false')->after('is_konfirmasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datapayment', function (Blueprint $table) {
            $table->dropColumn(['is_konfirmasi', 'is_iht']);
        });
    }
};

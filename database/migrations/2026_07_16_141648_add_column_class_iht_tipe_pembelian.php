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
            $table->integer('tipe_pembelian')->comment('1 membership|2 kelas')->nullable();
        });
        Schema::table('classes', function (Blueprint $table) {
            $table->boolean('iht')->nullable();
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
            $table->dropColumn('tipe_pembelian');
        });
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('iht');
        });
    }
};

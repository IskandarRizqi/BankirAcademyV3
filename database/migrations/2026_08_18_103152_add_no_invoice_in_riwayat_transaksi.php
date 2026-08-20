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
        Schema::table('riwayat_transaksi', function (Blueprint $table) {
            $table->string('no_invoice')->nullable();
            $table->timestamp('expired')->nullable();
            $table->integer('manual')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('riwayat_transaksi', function (Blueprint $table) {
            $table->dropColumn('no_invoice');
            $table->dropColumn('expired');
            $table->dropColumn('manual');
        });
    }
};

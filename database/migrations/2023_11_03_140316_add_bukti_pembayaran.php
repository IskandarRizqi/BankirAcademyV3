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
        if (!Schema::hasColumn('user_profile', 'image_bukti_pembayaran')) {
            Schema::table('user_profile', function (Blueprint $table) {
                $table->text('image_bukti_pembayaran')->nullable();
            });
        }
        if (!Schema::hasColumn('user_profile', 'status_membership')) {
            Schema::table('user_profile', function (Blueprint $table) {
                $table->integer('status_membership')->default(0)->comment('0: Tidak Aktif, 1:Aktif, 2:Proses');
            });
        }
        if (!Schema::hasColumn('user_profile', 'masa_aktif_membership')) {
            Schema::table('user_profile', function (Blueprint $table) {
                $table->date('masa_aktif_membership')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('user_profile', 'image_bukti_pembayaran')) {
            Schema::table('user_profile', function (Blueprint $table) {
                $table->dropColumn('image_bukti_pembayaran');
            });
        }
        if (Schema::hasColumn('user_profile', 'status_membership')) {
            Schema::table('user_profile', function (Blueprint $table) {
                $table->dropColumn('status_membership');
            });
        }
        if (Schema::hasColumn('user_profile', 'masa_aktif_membership')) {
            Schema::table('user_profile', function (Blueprint $table) {
                $table->dropColumn('masa_aktif_membership');
            });
        }
    }
};

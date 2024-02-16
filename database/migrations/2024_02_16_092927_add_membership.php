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
        if (!Schema::hasColumn('membership_models', 'cvats')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->integer('cvats')->default(0)->comment('0:tidak, 1:ya');
            });
        }
        if (!Schema::hasColumn('membership_models', 'cvbankir')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->integer('cvbankir')->default(0)->comment('0:tidak, 1:ya');
            });
        }
        if (!Schema::hasColumn('membership_models', 'lamaran_online')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->integer('lamaran_online')->default(0);
            });
        }
        if (!Schema::hasColumn('membership_models', 'lamara_offline')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->integer('lamara_offline')->default(0);
            });
        }
        if (!Schema::hasColumn('membership_models', 'pelatihan_gratis')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->integer('pelatihan_gratis')->default(0);
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
        if (Schema::hasColumn('membership_models', 'cvats')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->dropColumn('cvats');
            });
        }
        if (Schema::hasColumn('membership_models', 'cvbankir')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->dropColumn('cvbankir');
            });
        }
        if (Schema::hasColumn('membership_models', 'lamaran_online')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->dropColumn('lamaran_online');
            });
        }
        if (Schema::hasColumn('membership_models', 'lamara_offline')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->dropColumn('lamara_offline');
            });
        }
        if (Schema::hasColumn('membership_models', 'pelatihan_gratis')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->dropColumn('pelatihan_gratis');
            });
        }
    }
};

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
        if (!Schema::hasColumn('user_profile', 'id_member')) {
            Schema::table('user_profile', function (Blueprint $table) {
                $table->bigInteger('id_member')->nullable();
            });
        }
        Schema::create('membership_models', function (Blueprint $table) {
            $table->id();
            $table->double('harga');
            $table->integer('limit');
            $table->string('nama');
            $table->text('gambar');
            $table->text('keterangan');
            $table->json('jenis_kelas')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('user_profile', 'id_member')) {
            Schema::table('user_profile', function (Blueprint $table) {
                $table->dropColumn('id_member');
            });
        }
        Schema::dropIfExists('membership_models');
    }
};

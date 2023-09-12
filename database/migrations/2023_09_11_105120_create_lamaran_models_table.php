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
        Schema::create('lamaran_models', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('nama_lengkap');
            $table->string('nama_panggilan');
            $table->string('tmpttgllahir');
            $table->string('agama');
            $table->string('alamatdomisili');
            $table->string('telpdomisili');
            $table->string('kodepos');
            $table->string('namaorangtua');
            $table->string('jmlsaudara');
            $table->string('statusperkawinan');
            $table->string('namapasangan')->nullable();
            $table->string('namaorangtuasuamiistri')->nullable();
            $table->string('namaanak')->nullable();
            $table->string('namakakeknenek')->nullable();
            $table->string('namacucu')->nullable();
            $table->string('namasuamiistri')->nullable();
            $table->string('namamertua')->nullable();
            $table->string('namabesan')->nullable();
            $table->string('namasuamiistrianak')->nullable();
            $table->string('namakakeksuami')->nullable();
            $table->string('namasuamiistricucu')->nullable();
            $table->string('namasuamiistrisaudara')->nullable();
            $table->string('sdtahun')->nullable();
            $table->string('sdnama')->nullable();
            $table->string('sdfakultas')->nullable();
            $table->string('sdgelar')->nullable();
            $table->string('smptahun')->nullable();
            $table->string('smpnama')->nullable();
            $table->string('smpfakultas')->nullable();
            $table->string('smpgelar')->nullable();
            $table->string('smatahun')->nullable();
            $table->string('smanama')->nullable();
            $table->string('smafakultas')->nullable();
            $table->string('smagelar')->nullable();
            $table->string('akademitahun')->nullable();
            $table->string('akademinama')->nullable();
            $table->string('akademifakultas')->nullable();
            $table->string('akademigelar')->nullable();
            $table->string('perguruantahun')->nullable();
            $table->string('perguruannama')->nullable();
            $table->string('perguruanfakultas')->nullable();
            $table->string('perguruangelar')->nullable();
            $table->string('pascasarjanatahun')->nullable();
            $table->string('pascasarjananama')->nullable();
            $table->string('pascasarjanafakultas')->nullable();
            $table->string('pascasarjanagelar')->nullable();
            $table->text('pelatihannama')->nullable();
            $table->text('pelatihantahun')->nullable();
            $table->text('pelatihanpenyelanggara')->nullable();
            $table->text('pelatihanlokasi')->nullable();
            $table->text('pekerjaantahun')->nullable();
            $table->text('pekerjaanperusahaan')->nullable();
            $table->text('pekerjaanjabatan')->nullable();
            $table->text('pekerjaantanggungjawab')->nullable();
            $table->text('pekerjaanprestasi')->nullable();
            $table->text('pekerjaanpenghargaan')->nullable();
            $table->text('pekerjaantotalaset')->nullable();
            $table->text('pengalamanspesifik')->nullable();
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
        Schema::dropIfExists('lamaran_models');
    }
};

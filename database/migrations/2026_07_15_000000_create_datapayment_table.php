<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('datapayment', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice');
            $table->bigInteger('user_id');
            $table->bigInteger('class_id')->nullable();
            $table->string('pembelian')->comment('membership|kelas');
            $table->double('nominal')->default(0);
            $table->bigInteger('expired')->default(60)->comment('menit');
            $table->double('qty')->default(1);
            $table->integer('status')->default(2)->comment('1 lunas|2 pending|99 batal');
            $table->text('keterangan')->nullable();
            $table->text('link_payment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('datapayment');
    }
};

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
        Schema::create('class_pricing', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('class_id');
            $table->double('price');
            $table->integer('promo')->default(0);
            $table->double('promo_price')->nullable();
            $table->date('promo_start')->nullable();
            $table->date('promo_end')->nullable();
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
        Schema::dropIfExists('class_pricing');
    }
};

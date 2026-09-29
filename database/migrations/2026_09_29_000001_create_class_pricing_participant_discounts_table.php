<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_pricing_participant_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->unsignedInteger('minimum_participants');
            $table->decimal('discount_amount', 15, 2);
            $table->timestamps();

            // Beri nama indeks kustom yang lebih pendek (< 64 karakter)
            $table->unique(['class_id', 'minimum_participants'], 'cppd_class_min_part_unique');
            $table->index('class_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_pricing_participant_discounts');
    }
};

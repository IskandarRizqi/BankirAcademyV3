<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fake_order_customer', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->string('customer_name');
            $table->string('customer_city');
            $table->string('product_type', 20);
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name');
            $table->date('display_date');
            $table->dateTime('shown_at');
            $table->dateTime('next_display_at')->nullable();
            $table->timestamps();

            $table->index(['ip_address', 'display_date']);
            $table->unique(['display_date', 'customer_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fake_order_customer');
    }
};

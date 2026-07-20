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
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('password_sent_at')->nullable();
            $table->tinyInteger('is_active')->default(0)->nullable()->comment('0: deactive; 1: active');
            $table->longText('last_error')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('expires_at');
            $table->dropColumn('email_sent_at');
            $table->dropColumn('activated_at');
            $table->dropColumn('password_sent_at');
            $table->dropColumn('is_active');
            $table->dropColumn('last_error');
        });
    }
};

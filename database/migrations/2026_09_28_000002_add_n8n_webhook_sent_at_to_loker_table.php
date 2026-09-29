<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('loker', 'n8n_webhook_sent_at')) {
            Schema::table('loker', function (Blueprint $table) {
                $table->dateTime('n8n_webhook_sent_at')->nullable()->index();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('loker', 'n8n_webhook_sent_at')) {
            Schema::table('loker', function (Blueprint $table) {
                $table->dropColumn('n8n_webhook_sent_at');
            });
        }
    }
};

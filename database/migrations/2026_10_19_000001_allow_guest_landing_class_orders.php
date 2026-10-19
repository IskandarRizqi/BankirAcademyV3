<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('datapayment', function (Blueprint $table) {
            if (! Schema::hasColumn('datapayment', 'customer_name')) {
                $table->string('customer_name')->nullable();
            }

            if (! Schema::hasColumn('datapayment', 'customer_email')) {
                $table->string('customer_email')->nullable();
            }

            if (! Schema::hasColumn('datapayment', 'customer_phone')) {
                $table->string('customer_phone', 30)->nullable();
            }
        });
        DB::statement('ALTER TABLE datapayment MODIFY user_id BIGINT NULL');

        DB::statement('ALTER TABLE class_payment MODIFY user_id BIGINT NULL');

        DB::statement('ALTER TABLE class_participant MODIFY user_id BIGINT NULL');

        DB::statement('ALTER TABLE sertifikat_peserta MODIFY user_id BIGINT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE sertifikat_peserta MODIFY user_id BIGINT NOT NULL');

        DB::statement('ALTER TABLE class_participant MODIFY user_id BIGINT NOT NULL');

        DB::statement('ALTER TABLE class_payment MODIFY user_id BIGINT NOT NULL');

        Schema::table('datapayment', function (Blueprint $table) {
            foreach (['customer_name', 'customer_email', 'customer_phone'] as $column) {
                if (Schema::hasColumn('datapayment', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
        DB::statement('ALTER TABLE datapayment MODIFY user_id BIGINT NOT NULL');
    }
};

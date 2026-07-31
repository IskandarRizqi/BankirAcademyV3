<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('class_pricing', function (Blueprint $table) {
            if (!Schema::hasColumn('class_pricing', 'discount_type')) {
                $table->string('discount_type', 20)->default('nominal')->after('promo_price');
            }

            if (!Schema::hasColumn('class_pricing', 'discount_value')) {
                $table->decimal('discount_value', 15, 2)->default(0)->after('discount_type');
            }
        });

        DB::table('class_pricing')
            ->where('promo', 1)
            ->where('promo_price', '>', 0)
            ->update([
                'discount_type' => 'nominal',
                'discount_value' => DB::raw('promo_price'),
            ]);

        Schema::create('class_pricing_membership_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->string('membership_type', 20);
            $table->string('discount_category', 40);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->timestamps();

            $table->unique(
                ['class_id', 'membership_type', 'discount_category'],
                'class_membership_discount_unique'
            );
            $table->index('class_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_pricing_membership_discounts');

        Schema::table('class_pricing', function (Blueprint $table) {
            if (Schema::hasColumn('class_pricing', 'discount_value')) {
                $table->dropColumn('discount_value');
            }

            if (Schema::hasColumn('class_pricing', 'discount_type')) {
                $table->dropColumn('discount_type');
            }
        });
    }
};

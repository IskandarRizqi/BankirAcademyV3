<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('classes', 'slug')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('title');
            });
        }

        $usedSlugs = [];

        DB::table('classes')
            ->orderBy('id')
            ->get(['id', 'title'])
            ->each(function ($class) use (&$usedSlugs) {
                $baseSlug = Str::slug((string) $class->title) ?: 'kelas';
                $slug = $baseSlug;
                $suffix = 2;

                while (isset($usedSlugs[$slug])) {
                    $slug = $baseSlug.'-'.$suffix;
                    $suffix++;
                }

                DB::table('classes')
                    ->where('id', $class->id)
                    ->update(['slug' => $slug]);

                $usedSlugs[$slug] = true;
            });

        Schema::table('classes', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down()
    {
        if (Schema::hasColumn('classes', 'slug')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropUnique('classes_slug_unique');
                $table->dropColumn('slug');
            });
        }
    }

};

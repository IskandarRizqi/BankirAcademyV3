<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $connection = config('activitylog.database_connection');
        $tableName = config('activitylog.table_name');
        $schema = Schema::connection($connection);

        if (! $schema->hasColumn($tableName, 'attribute_changes')) {
            $schema->table($tableName, function (Blueprint $table): void {
                $table->json('attribute_changes')->nullable()->after('causer_id');
            });
        }

        if ($schema->hasColumn($tableName, 'batch_uuid')) {
            $schema->table($tableName, function (Blueprint $table): void {
                $table->dropColumn('batch_uuid');
            });
        }

        $query = DB::connection($connection)
            ->table($tableName)
            ->whereNotNull('properties');

        $query->orderBy('id')->chunkById(100, function ($activities) use ($connection, $tableName): void {
            foreach ($activities as $activity) {
                $properties = json_decode($activity->properties, true);

                if (! is_array($properties)) {
                    continue;
                }

                $changes = array_intersect_key($properties, array_flip(['attributes', 'old']));
                $remaining = array_diff_key($properties, array_flip(['attributes', 'old']));

                DB::connection($connection)
                    ->table($tableName)
                    ->where('id', $activity->id)
                    ->update([
                        'attribute_changes' => empty($changes) ? null : json_encode($changes),
                        'properties' => empty($remaining) ? null : json_encode($remaining),
                    ]);
            }
        });
    }

    public function down(): void
    {
        $connection = config('activitylog.database_connection');
        $tableName = config('activitylog.table_name');
        $schema = Schema::connection($connection);

        if ($schema->hasColumn($tableName, 'attribute_changes')) {
            $schema->table($tableName, function (Blueprint $table): void {
                $table->dropColumn('attribute_changes');
            });
        }

        if (! $schema->hasColumn($tableName, 'batch_uuid')) {
            $schema->table($tableName, function (Blueprint $table): void {
                $table->uuid('batch_uuid')->nullable()->after('properties');
            });
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('concepts', function (Blueprint $table) {
            $table->json('tier_ratings')->nullable()->after('tier_xp');
        });

        DB::table('concepts')->whereNull('tier_ratings')->update([
            'tier_ratings' => json_encode([
                'junior' => ['sum' => 0, 'count' => 0],
                'mid' => ['sum' => 0, 'count' => 0],
                'senior' => ['sum' => 0, 'count' => 0],
            ])
        ]);
    }

    public function down(): void
    {
        Schema::table('concepts', function (Blueprint $table) {
            $table->dropColumn('tier_ratings');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('concepts', function (Blueprint $table) {
            $table->json('tier_xp')->nullable()->after('xp');
        });

        DB::table('concepts')->whereNull('tier_xp')->update([
            'tier_xp' => json_encode(['junior' => 0, 'mid' => 0, 'senior' => 0])
        ]);
    }

    public function down(): void
    {
        Schema::table('concepts', function (Blueprint $table) {
            $table->dropColumn('tier_xp');
        });
    }
};

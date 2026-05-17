<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('concepts', function (Blueprint $table) {
            $table->json('practice_streak')->nullable()->after('tier_ratings');
        });
    }

    public function down(): void
    {
        Schema::table('concepts', function (Blueprint $table) {
            $table->dropColumn('practice_streak');
        });
    }
};

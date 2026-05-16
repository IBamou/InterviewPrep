<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('concepts', function (Blueprint $table) {
            $table->unsignedInteger('practice_sets_completed')->default(0)->after('practice_sessions');
            $table->decimal('total_rating_sum', 8, 2)->default(0)->after('practice_sets_completed');
        });
    }

    public function down(): void
    {
        Schema::table('concepts', function (Blueprint $table) {
            $table->dropColumn(['practice_sets_completed', 'total_rating_sum']);
        });
    }
};

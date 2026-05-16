<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('concepts', function (Blueprint $table) {
            $table->unsignedInteger('xp')->default(0)->after('status');
            $table->json('unlocked_tiers')->nullable()->after('xp');
            $table->decimal('mastery_score', 5, 2)->nullable()->after('unlocked_tiers');
            $table->json('practice_sessions')->nullable()->after('mastery_score');
        });

        $columns = Schema::getColumnListing('concepts');
        if (in_array('difficulty', $columns)) {
            Schema::table('concepts', function (Blueprint $table) {
                $table->dropColumn('difficulty');
            });
        }
        if (in_array('difficulty_history', $columns)) {
            Schema::table('concepts', function (Blueprint $table) {
                $table->dropColumn('difficulty_history');
            });
        }
    }

    public function down(): void
    {
        $columns = Schema::getColumnListing('concepts');
        if (!in_array('difficulty', $columns)) {
            Schema::table('concepts', function (Blueprint $table) {
                $table->string('difficulty')->default('junior')->after('status');
            });
        }
        if (!in_array('difficulty_history', $columns)) {
            Schema::table('concepts', function (Blueprint $table) {
                $table->json('difficulty_history')->nullable()->after('mastery_score');
            });
        }

        Schema::table('concepts', function (Blueprint $table) {
            $cols = Schema::getColumnListing('concepts');
            if (in_array('xp', $cols)) $table->dropColumn('xp');
            if (in_array('unlocked_tiers', $cols)) $table->dropColumn('unlocked_tiers');
            if (in_array('mastery_score', $cols)) $table->dropColumn('mastery_score');
            if (in_array('practice_sessions', $cols)) $table->dropColumn('practice_sessions');
        });
    }
};

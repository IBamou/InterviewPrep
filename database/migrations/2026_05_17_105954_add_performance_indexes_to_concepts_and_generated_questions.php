<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('concepts', function (Blueprint $table) {
            $table->index(['domain_id', 'status']);
            $table->index(['updated_at']);
        });

        Schema::table('generated_questions', function (Blueprint $table) {
            $table->index(['concept_id', 'tier', 'set_number'], 'gq_concept_tier_set_idx');
        });
    }

    public function down(): void
    {
        Schema::table('concepts', function (Blueprint $table) {
            $table->dropIndex(['domain_id', 'status']);
            $table->dropIndex(['updated_at']);
        });

        Schema::table('generated_questions', function (Blueprint $table) {
            $table->dropIndex('gq_concept_tier_set_idx');
        });
    }
};

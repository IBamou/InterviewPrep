<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('student')->after('email');
            $table->string('specialization')->nullable()->after('status');
            $table->string('experience_years')->nullable()->after('specialization');
            $table->json('tech_stack')->nullable()->after('experience_years');
            $table->string('interview_goal')->nullable()->after('tech_stack');
            $table->boolean('onboarding_completed')->default(false)->after('interview_goal');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'specialization', 'experience_years', 'tech_stack', 'interview_goal', 'onboarding_completed']);
        });
    }
};

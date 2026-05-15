<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('generated_questions', function (Blueprint $table) {
            $table->text('answer')->nullable()->after('question');
            $table->integer('rating')->nullable()->after('answer');
            $table->text('feedback')->nullable()->after('rating');
            $table->text('model_answer')->nullable()->after('feedback');
            $table->integer('set_number')->default(1)->after('model_answer');
        });
    }

    public function down(): void
    {
        Schema::table('generated_questions', function (Blueprint $table) {
            $table->dropColumn(['answer', 'rating', 'feedback', 'model_answer', 'set_number']);
        });
    }
};

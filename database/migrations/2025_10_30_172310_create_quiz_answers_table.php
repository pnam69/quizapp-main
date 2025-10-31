<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('quiz_answers')) {
            return;
        }

        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_header_id')->constrained('quiz_headers')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            // make answer_id nullable while developing to avoid insert failures
            $table->foreignId('answer_id')->nullable()->constrained('answers')->onDelete('cascade');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'quiz_header_id', 'question_id'], 'uq_quiz_answer_user_quiz_question');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_answers');
    }
};

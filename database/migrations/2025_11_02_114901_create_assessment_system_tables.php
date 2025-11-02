<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Assessments table (replaces tests/quiz_headers)
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['test', 'quiz', 'practice', 'exam'])->default('test');

            // Metadata
            $table->integer('time_limit')->nullable()->comment('Time limit in minutes');
            $table->integer('passing_score')->default(70);
            $table->integer('attempts_allowed')->default(1)->comment('-1 for unlimited');
            $table->boolean('shuffle_questions')->default(false);
            $table->boolean('shuffle_options')->default(false);
            $table->boolean('show_correct_answers')->default(true);

            // Assignment
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('classroom_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('section_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('certification_id')->nullable()->constrained()->nullOnDelete();

            // Scheduling
            $table->dateTime('available_from')->nullable();
            $table->dateTime('available_until')->nullable();

            // Status
            $table->boolean('is_published')->default(false);
            $table->boolean('is_active')->default(true);

            // Settings
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->string('category', 100)->nullable();
            $table->json('tags')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['teacher_id', 'is_published']);
            $table->index(['classroom_id', 'is_active']);
        });

        // 2. Assessment Questions table
        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();

            // Question content
            $table->text('question_text');
            $table->enum('question_type', ['multiple_choice', 'true_false', 'multiple_answer', 'fill_blank'])->default('multiple_choice');
            $table->integer('points')->default(1);

            // Display
            $table->integer('order')->default(0);
            $table->string('image_url')->nullable();
            $table->text('explanation')->nullable()->comment('Shown after answering');

            // Settings
            $table->boolean('is_required')->default(true);

            $table->timestamps();

            $table->index(['assessment_id', 'order']);
        });

        // 3. Question Options table
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('assessment_questions')->cascadeOnDelete();

            // Option content
            $table->text('option_text');
            $table->boolean('is_correct')->default(false);
            $table->integer('order')->default(0);

            // Optional feedback
            $table->text('feedback')->nullable();

            $table->timestamps();

            $table->index(['question_id', 'order']);
        });

        // 4. Assessment Attempts table
        Schema::create('assessment_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Attempt info
            $table->integer('attempt_number')->default(1);
            $table->dateTime('started_at');
            $table->dateTime('submitted_at')->nullable();
            $table->integer('time_taken')->nullable()->comment('Time in seconds');

            // Results
            $table->decimal('score', 5, 2)->nullable();
            $table->integer('points_earned')->nullable();
            $table->integer('total_points')->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->boolean('passed')->nullable();

            // Status
            $table->enum('status', ['in_progress', 'completed', 'abandoned', 'expired'])->default('in_progress');

            // Denormalized answers for quick retrieval
            $table->json('answers')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'assessment_id']);
            $table->index(['status', 'submitted_at']);
        });

        // 5. Attempt Answers table (detailed tracking)
        Schema::create('attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('assessment_attempts')->cascadeOnDelete();
            $table->foreignId('question_id')->nullable()->constrained('assessment_questions')->nullOnDelete();

            // Answer
            $table->json('selected_options')->nullable()->comment('Array of option IDs');
            $table->text('answer_text')->nullable()->comment('For fill-in-the-blank');

            // Grading
            $table->boolean('is_correct')->nullable();
            $table->decimal('points_earned', 5, 2)->default(0);

            // Timing
            $table->integer('time_spent')->nullable()->comment('Seconds spent on question');
            $table->dateTime('answered_at')->nullable();

            $table->timestamps();

            $table->index(['attempt_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attempt_answers');
        Schema::dropIfExists('assessment_attempts');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('assessment_questions');
        Schema::dropIfExists('assessments');
    }
};

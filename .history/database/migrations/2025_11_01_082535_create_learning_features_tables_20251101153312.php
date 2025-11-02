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
        // Flashcards
        Schema::create('flashcard_decks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Creator
            $table->foreignId('section_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('classroom_id')->nullable()->constrained()->nullOnDelete();
            $table->string('visibility')->default('private'); // private, classroom, public
            $table->string('cover_image')->nullable();
            $table->integer('card_count')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('section_id');
        });

        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deck_id')->constrained('flashcard_decks')->cascadeOnDelete();
            $table->text('front_content'); // Question/Term
            $table->text('back_content'); // Answer/Definition
            $table->string('front_media')->nullable(); // Image/Audio for front
            $table->string('back_media')->nullable(); // Image/Audio for back
            $table->string('front_media_type')->nullable(); // image, audio, video
            $table->string('back_media_type')->nullable();
            $table->integer('order')->default(0);
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->index('deck_id');
        });

        // Flashcard Study Sessions
        Schema::create('flashcard_study_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('deck_id')->constrained('flashcard_decks')->cascadeOnDelete();
            $table->integer('cards_studied')->default(0);
            $table->integer('cards_mastered')->default(0);
            $table->integer('duration_seconds')->default(0);
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });

        // Card Mastery Tracking (Spaced Repetition)
        Schema::create('user_card_mastery', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('flashcard_id')->constrained()->cascadeOnDelete();
            $table->integer('ease_factor')->default(250); // For SM-2 algorithm
            $table->integer('interval')->default(0); // Days until next review
            $table->integer('repetitions')->default(0);
            $table->timestamp('next_review_date')->nullable();
            $table->string('mastery_level')->default('new'); // new, learning, reviewing, mastered
            $table->integer('correct_count')->default(0);
            $table->integer('incorrect_count')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'flashcard_id']);
            $table->index(['user_id', 'next_review_date']);
        });

        // Learning Paths
        Schema::create('learning_paths', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('section_id')->nullable()->constrained()->nullOnDelete();
            $table->string('difficulty_level')->default('beginner'); // beginner, intermediate, advanced
            $table->string('cover_image')->nullable();
            $table->integer('estimated_hours')->nullable();
            $table->boolean('is_published')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Learning Path Modules
        Schema::create('learning_path_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_path_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('module_type'); // quiz, flashcards, hub_resource, video, reading
            $table->foreignId('content_id')->nullable(); // ID of quiz, deck, hub, etc.
            $table->string('content_type')->nullable(); // Quiz, FlashcardDeck, Hub
            $table->integer('order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->integer('min_score')->nullable(); // Minimum score to pass
            $table->timestamps();

            $table->index('learning_path_id');
        });

        // User Learning Path Progress
        Schema::create('user_learning_paths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('learning_path_id')->constrained()->cascadeOnDelete();
            $table->integer('modules_completed')->default(0);
            $table->integer('total_modules')->default(0);
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->string('status')->default('in_progress'); // in_progress, completed, paused
            $table->timestamps();

            $table->unique(['user_id', 'learning_path_id']);
            $table->index('user_id');
        });

        // User Module Progress
        Schema::create('user_module_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('module_id')->constrained('learning_path_modules')->cascadeOnDelete();
            $table->boolean('is_completed')->default(false);
            $table->integer('score')->nullable();
            $table->integer('attempts')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'module_id']);
        });

        // Study Goals
        Schema::create('study_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('goal_type'); // daily_quizzes, weekly_xp, cards_per_day, etc.
            $table->integer('target_value');
            $table->integer('current_value')->default(0);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('frequency')->default('daily'); // daily, weekly, monthly, custom
            $table->boolean('is_active')->default(true);
            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            $table->index('user_id');
        });

        // Adaptive Learning Data
        Schema::create('user_topic_performance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->integer('questions_attempted')->default(0);
            $table->integer('questions_correct')->default(0);
            $table->decimal('accuracy_rate', 5, 2)->default(0);
            $table->integer('average_time_seconds')->nullable();
            $table->string('difficulty_level')->default('medium'); // easy, medium, hard
            $table->timestamp('last_practiced_at')->nullable();
            $table->integer('mastery_score')->default(0); // 0-100
            $table->timestamps();

            $table->unique(['user_id', 'section_id']);
            $table->index('user_id');
        });

        // Study Sessions (for analytics)
        Schema::create('study_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('session_type'); // quiz, flashcards, reading
            $table->foreignId('content_id')->nullable();
            $table->string('content_type')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->integer('duration_seconds')->default(0);
            $table->json('performance_data')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_sessions');
        Schema::dropIfExists('user_topic_performance');
        Schema::dropIfExists('study_goals');
        Schema::dropIfExists('user_module_progress');
        Schema::dropIfExists('user_learning_paths');
        Schema::dropIfExists('learning_path_modules');
        Schema::dropIfExists('learning_paths');
        Schema::dropIfExists('user_card_mastery');
        Schema::dropIfExists('flashcard_study_sessions');
        Schema::dropIfExists('flashcards');
        Schema::dropIfExists('flashcard_decks');
    }
};

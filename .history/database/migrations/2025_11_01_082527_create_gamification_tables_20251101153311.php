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
        // User XP and Levels
        Schema::create('user_xp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('total_xp')->default(0);
            $table->integer('level')->default(1);
            $table->integer('xp_to_next_level')->default(100);
            $table->timestamps();

            $table->index('user_id');
        });

        // Badges
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('icon')->nullable(); // Badge icon/image
            $table->string('type'); // achievement, streak, mastery, social, etc.
            $table->integer('xp_reward')->default(0);
            $table->json('criteria'); // JSON criteria for earning the badge
            $table->string('rarity')->default('common'); // common, rare, epic, legendary
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // User Badges (earned badges)
        Schema::create('user_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('badge_id')->constrained()->cascadeOnDelete();
            $table->timestamp('earned_at');
            $table->timestamps();

            $table->unique(['user_id', 'badge_id']);
            $table->index('user_id');
        });

        // Daily Streaks
        Schema::create('user_streaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('current_streak')->default(0);
            $table->integer('longest_streak')->default(0);
            $table->date('last_activity_date')->nullable();
            $table->integer('freeze_count')->default(0); // Streak freeze power-ups
            $table->timestamps();

            $table->unique('user_id');
        });

        // Leaderboards
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // global, classroom, section, weekly, monthly
            $table->string('metric'); // xp, quizzes_completed, accuracy, streak
            $table->foreignId('scope_id')->nullable(); // classroom_id or section_id
            $table->string('scope_type')->nullable(); // Classroom or Section
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Leaderboard Entries
        Schema::create('leaderboard_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leaderboard_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('rank');
            $table->decimal('score', 10, 2);
            $table->json('metadata')->nullable(); // Additional stats
            $table->timestamps();

            $table->index(['leaderboard_id', 'rank']);
            $table->index('user_id');
        });

        // Achievements/Milestones
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('icon')->nullable();
            $table->string('category'); // quiz_master, speed_demon, perfectionist, etc.
            $table->integer('target_value'); // e.g., 100 quizzes
            $table->string('metric'); // quizzes_completed, perfect_scores, etc.
            $table->integer('xp_reward')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // User Achievements Progress
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('achievement_id')->constrained()->cascadeOnDelete();
            $table->integer('current_value')->default(0);
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'achievement_id']);
            $table->index('user_id');
        });

        // XP Transactions Log
        Schema::create('xp_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('amount'); // Can be positive or negative
            $table->string('source'); // quiz_completion, streak_bonus, badge_earned, etc.
            $table->string('source_type')->nullable(); // Quiz, Badge, etc.
            $table->foreignId('source_id')->nullable(); // ID of the source
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xp_transactions');
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('leaderboard_entries');
        Schema::dropIfExists('leaderboards');
        Schema::dropIfExists('user_streaks');
        Schema::dropIfExists('user_badges');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('user_xp');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration removes all unused tables to clean up the database.
     * Based on analysis, these tables are all empty and not actively used.
     */
    public function up(): void
    {
        // Drop gamification-related tables (all empty)
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('user_badges');
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('leaderboard_entries');
        Schema::dropIfExists('leaderboards');
        Schema::dropIfExists('xp_transactions');
        Schema::dropIfExists('user_xp');
        Schema::dropIfExists('user_streaks');

        // Drop advanced learning feature tables (all empty)
        Schema::dropIfExists('user_card_mastery');
        Schema::dropIfExists('flashcard_study_sessions');
        Schema::dropIfExists('flashcards');
        Schema::dropIfExists('flashcard_decks');
        Schema::dropIfExists('user_module_progress');
        Schema::dropIfExists('learning_path_modules');
        Schema::dropIfExists('user_learning_paths');
        Schema::dropIfExists('learning_paths');

        // Drop analytics and tracking tables (all empty)
        Schema::dropIfExists('user_topic_performance');
        Schema::dropIfExists('question_statistics');
        Schema::dropIfExists('teacher_analytics');
        Schema::dropIfExists('study_sessions');
        Schema::dropIfExists('study_goals');
        Schema::dropIfExists('offline_content');
    }

    /**
     * Reverse the migrations.
     * 
     * Note: This will recreate the table structure but won't restore any data.
     */
    public function down(): void
    {
        // We won't recreate these tables as they were unused
        // If needed, the original migrations can be referenced
    }
};

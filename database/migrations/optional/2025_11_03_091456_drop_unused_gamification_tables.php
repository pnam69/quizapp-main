<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * OPTIONAL CLEANUP MIGRATION
     * 
     * ⚠️ WARNING: Only run this if you're ABSOLUTELY SURE you won't use these features!
     * 
     * This migration drops tables related to:
     * - Gamification (achievements, badges, XP, streaks, leaderboards)
     * - Flashcards system
     * - Learning paths
     * - Subscriptions
     * 
     * These tables were created for future features but may not be currently in use.
     * 
     * BEFORE RUNNING:
     * 1. BACKUP YOUR DATABASE!
     * 2. Make sure no code references these tables
     * 3. Test in development first
     */
    public function up(): void
    {
        // Drop gamification tables in correct order (respect foreign keys)
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('user_badges');
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('leaderboard_entries');
        Schema::dropIfExists('leaderboards');
        Schema::dropIfExists('xp_transactions');
        Schema::dropIfExists('user_xps');
        Schema::dropIfExists('user_streaks');

        // Drop flashcard tables
        Schema::dropIfExists('flashcards');
        Schema::dropIfExists('flashcard_decks');

        // Drop learning path tables
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('learning_paths');
    }

    /**
     * Reverse the migrations.
     * 
     * Note: This will recreate the table structure but NOT the data!
     * You would need to restore from backup to get data back.
     */
    public function down(): void
    {
        // Recreate tables (structures only - data will be lost)

        // Achievements table
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('points')->default(0);
            $table->string('type')->default('custom');
            $table->json('criteria')->nullable();
            $table->timestamps();
        });

        // Badges table
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->default('#3B82F6');
            $table->string('level')->default('bronze');
            $table->json('requirements')->nullable();
            $table->timestamps();
        });

        // User achievements pivot
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('achievement_id')->constrained()->onDelete('cascade');
            $table->timestamp('earned_at')->nullable();
            $table->timestamps();
        });

        // User badges pivot
        Schema::create('user_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('badge_id')->constrained()->onDelete('cascade');
            $table->timestamp('earned_at')->nullable();
            $table->timestamps();
        });

        // Leaderboards table
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('global');
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->timestamps();
        });

        // Leaderboard entries
        Schema::create('leaderboard_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leaderboard_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('score')->default(0);
            $table->integer('rank')->nullable();
            $table->timestamps();
        });

        // XP transactions
        Schema::create('xp_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('amount');
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        // User XP
        Schema::create('user_xps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('total_xp')->default(0);
            $table->integer('level')->default(1);
            $table->timestamps();
        });

        // User streaks
        Schema::create('user_streaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('current_streak')->default(0);
            $table->integer('longest_streak')->default(0);
            $table->date('last_activity_date')->nullable();
            $table->timestamps();
        });

        // Flashcard decks
        Schema::create('flashcard_decks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('section_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });

        // Flashcards
        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flashcard_deck_id')->constrained()->onDelete('cascade');
            $table->text('front');
            $table->text('back');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Learning paths
        Schema::create('learning_paths', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('section_id')->nullable()->constrained()->onDelete('set null');
            $table->json('sequence')->nullable();
            $table->timestamps();
        });

        // Subscriptions
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('learning_path_id')->constrained()->onDelete('cascade');
            $table->integer('progress')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }
};

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GamificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Badges
        $badges = [
            // Streak Badges
            [
                'name' => '🔥 First Streak',
                'description' => 'Complete your first day of studying!',
                'icon' => 'heroicon-o-fire',
                'type' => 'streak',
                'xp_reward' => 50,
                'criteria' => json_encode(['streak_days' => 1]),
                'rarity' => 'common',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '🔥 Week Warrior',
                'description' => 'Maintain a 7-day study streak',
                'icon' => 'heroicon-o-fire',
                'type' => 'streak',
                'xp_reward' => 200,
                'criteria' => json_encode(['streak_days' => 7]),
                'rarity' => 'rare',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '🔥 Month Master',
                'description' => 'Study for 30 consecutive days!',
                'icon' => 'heroicon-o-fire',
                'type' => 'streak',
                'xp_reward' => 1000,
                'criteria' => json_encode(['streak_days' => 30]),
                'rarity' => 'epic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '⭐ First Steps',
                'description' => 'Complete your first quiz',
                'icon' => 'heroicon-o-star',
                'type' => 'achievement',
                'xp_reward' => 100,
                'criteria' => json_encode(['quizzes_completed' => 1]),
                'rarity' => 'common',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '🎯 Perfect Score',
                'description' => 'Score 100% on a quiz',
                'icon' => 'heroicon-o-trophy',
                'type' => 'achievement',
                'xp_reward' => 150,
                'criteria' => json_encode(['perfect_score' => true]),
                'rarity' => 'rare',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '🏆 Quiz Master',
                'description' => 'Complete 50 quizzes',
                'icon' => 'heroicon-o-academic-cap',
                'type' => 'achievement',
                'xp_reward' => 500,
                'criteria' => json_encode(['quizzes_completed' => 50]),
                'rarity' => 'epic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('badges')->insert($badges);

        // Seed Achievements
        $achievements = [
            [
                'name' => 'Quiz Apprentice',
                'description' => 'Complete 10 quizzes',
                'icon' => 'heroicon-o-academic-cap',
                'category' => 'quiz_completion',
                'target_value' => 10,
                'metric' => 'quizzes_completed',
                'xp_reward' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Quiz Expert',
                'description' => 'Complete 50 quizzes',
                'icon' => 'heroicon-o-academic-cap',
                'category' => 'quiz_completion',
                'target_value' => 50,
                'metric' => 'quizzes_completed',
                'xp_reward' => 500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Perfectionist',
                'description' => 'Get 10 perfect scores',
                'icon' => 'heroicon-o-star',
                'category' => 'perfect_scores',
                'target_value' => 10,
                'metric' => 'perfect_scores',
                'xp_reward' => 800,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('achievements')->insert($achievements);

        $this->command->info('✓ Created ' . count($badges) . ' badges');
        $this->command->info('✓ Created ' . count($achievements) . ' achievements');
        $this->command->info('Gamification system is ready! 🎮');
    }
}

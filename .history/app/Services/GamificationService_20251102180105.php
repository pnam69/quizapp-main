<?php

namespace App\Services;

use App\Models\User;
use App\Models\Badge;
use App\Models\Achievement;
use App\Models\UserXp;
use App\Models\UserStreak;
use App\Models\XpTransaction;
use App\Models\Leaderboard;
use App\Models\LeaderboardEntry;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GamificationService
{
    /**
     * Award XP to a user for completing a quiz
     */
    public function awardQuizCompletionXp(User $user, int $score, int $totalQuestions, string $difficulty = 'medium'): void
    {
        $baseXp = $this->calculateQuizXp($score, $totalQuestions, $difficulty);

        DB::transaction(function () use ($user, $baseXp, $score, $totalQuestions) {
            // Get or create user XP record
            $userXp = $user->userXp ?? new UserXp(['user_id' => $user->id, 'total_xp' => 0, 'level' => 1]);

            // Award XP
            $userXp->total_xp += $baseXp;
            $userXp->level = $this->calculateLevel($userXp->total_xp);
            $userXp->save();

            // Record transaction
            XpTransaction::create([
                'user_id' => $user->id,
                'amount' => $baseXp,
                'source' => 'quiz_completion',
                'description' => "Quiz completed: {$score}/{$totalQuestions} correct",
            ]);

            // Update user streak
            $this->updateStreak($user);

            // Check for badge unlocks
            $this->checkBadgeUnlocks($user);

            // Check for achievement progress
            $this->updateAchievementProgress($user, 'quizzes_completed', 1);
            $this->updateAchievementProgress($user, 'perfect_scores', $score === $totalQuestions ? 1 : 0);

            // Update leaderboards
            $this->updateLeaderboards($user);
        });
    }

    /**
     * Calculate XP for quiz completion based on score and difficulty
     */
    private function calculateQuizXp(int $score, int $totalQuestions, string $difficulty): int
    {
        $accuracy = $totalQuestions > 0 ? ($score / $totalQuestions) : 0;
        $baseXp = 10; // Base XP for completing a quiz

        // Bonus for accuracy
        $accuracyBonus = (int)($accuracy * 20); // Up to 20 bonus XP for 100% accuracy

        // Difficulty multiplier
        $difficultyMultiplier = match ($difficulty) {
            'easy' => 1.0,
            'medium' => 1.5,
            'hard' => 2.0,
            'expert' => 2.5,
            default => 1.0
        };

        return (int)(($baseXp + $accuracyBonus) * $difficultyMultiplier);
    }

    /**
     * Calculate user level based on total XP
     */
    private function calculateLevel(int $totalXp): int
    {
        // Level calculation: level = floor(sqrt(xp / 100)) + 1
        // This means: Level 1 = 0-99 XP, Level 2 = 100-399 XP, Level 3 = 400-899 XP, etc.
        return (int)floor(sqrt($totalXp / 100)) + 1;
    }

    /**
     * Update user streak information
     */
    private function updateStreak(User $user): void
    {
        $streak = $user->userStreak ?? new UserStreak([
            'user_id' => $user->id,
            'current_streak' => 0,
            'longest_streak' => 0,
            'last_activity_date' => null
        ]);

        $today = Carbon::today();

        if ($streak->last_activity_date) {
            $lastActivity = Carbon::parse($streak->last_activity_date);

            if ($lastActivity->isYesterday()) {
                // Continue streak
                $streak->current_streak += 1;
            } elseif ($lastActivity->lt($today->copy()->subDays(1))) {
                // Streak broken
                $streak->current_streak = 1;
            }
            // If same day, don't change streak
        } else {
            // First activity
            $streak->current_streak = 1;
        }

        // Update longest streak if current is higher
        if ($streak->current_streak > $streak->longest_streak) {
            $streak->longest_streak = $streak->current_streak;
        }

        $streak->last_activity_date = $today;
        $streak->save();

        // Check streak-based achievements
        $this->updateAchievementProgress($user, 'streak', $streak->current_streak);
    }

    /**
     * Check and unlock badges for user
     */
    private function checkBadgeUnlocks(User $user): void
    {
        $badges = Badge::where('is_active', true)->get();

        foreach ($badges as $badge) {
            // Skip if user already has this badge
            if ($user->badges()->where('badge_id', $badge->id)->exists()) {
                continue;
            }

            $unlocked = false;

            switch ($badge->type) {
                case 'quiz_completion':
                    $criteria = $badge->criteria;
                    if (isset($criteria['quizzes_completed'])) {
                        $completedQuizzes = $user->quizHeaders()->where('completed', true)->count();
                        $unlocked = $completedQuizzes >= $criteria['quizzes_completed'];
                    }
                    break;

                case 'xp_level':
                    $criteria = $badge->criteria;
                    if (isset($criteria['level'])) {
                        $userXp = $user->userXp;
                        $unlocked = $userXp && $userXp->level >= $criteria['level'];
                    }
                    break;

                case 'streak':
                    $criteria = $badge->criteria;
                    if (isset($criteria['days'])) {
                        $streak = $user->userStreak;
                        $unlocked = $streak && $streak->current_streak >= $criteria['days'];
                    }
                    break;

                case 'perfect_score':
                    $criteria = $badge->criteria;
                    if (isset($criteria['count'])) {
                        $perfectScores = $user->quizHeaders()
                            ->where('completed', true)
                            ->whereRaw('score = quiz_size')
                            ->count();
                        $unlocked = $perfectScores >= $criteria['count'];
                    }
                    break;
            }

            if ($unlocked) {
                $user->badges()->attach($badge->id, [
                    'earned_at' => now(),
                    'is_showcased' => false
                ]);

                // Award badge XP bonus
                if ($badge->xp_reward > 0) {
                    $this->awardXpBonus($user, $badge->xp_reward, "Badge unlocked: {$badge->name}");
                }
            }
        }
    }

    /**
     * Update achievement progress for user
     */
    private function updateAchievementProgress(User $user, string $metric, int $increment = 1): void
    {
        $achievements = Achievement::where('is_active', true)
            ->where('metric', $metric)
            ->get();

        foreach ($achievements as $achievement) {
            $userAchievement = $user->achievements()
                ->where('achievement_id', $achievement->id)
                ->first();

            if (!$userAchievement) {
                // Initialize achievement progress
                $user->achievements()->attach($achievement->id, [
                    'progress' => $increment,
                    'earned_at' => null
                ]);
                $currentProgress = $increment;
            } else {
                // Update existing progress
                $currentProgress = $userAchievement->pivot->progress + $increment;
                $user->achievements()->updateExistingPivot($achievement->id, [
                    'progress' => $currentProgress
                ]);
            }

            // Check if achievement is completed
            if ($currentProgress >= $achievement->target_value && !$userAchievement?->pivot?->earned_at) {
                $user->achievements()->updateExistingPivot($achievement->id, [
                    'earned_at' => now()
                ]);

                // Award achievement XP bonus
                if ($achievement->xp_reward > 0) {
                    $this->awardXpBonus($user, $achievement->xp_reward, "Achievement unlocked: {$achievement->name}");
                }
            }
        }
    }

    /**
     * Update leaderboard entries for user
     */
    private function updateLeaderboards(User $user): void
    {
        $leaderboards = Leaderboard::where('is_active', true)->get();

        foreach ($leaderboards as $leaderboard) {
            $entry = LeaderboardEntry::firstOrNew([
                'leaderboard_id' => $leaderboard->id,
                'user_id' => $user->id,
            ]);

            // Calculate score based on leaderboard metric
            $score = $this->calculateLeaderboardScore($user, $leaderboard->metric);

            $entry->score = $score;
            $entry->rank = null; // Will be calculated later
            $entry->last_updated = now();
            $entry->save();
        }

        // Update ranks for all leaderboards
        $this->updateLeaderboardRanks();
    }

    /**
     * Calculate score for leaderboard based on metric
     */
    private function calculateLeaderboardScore(User $user, string $metric): int
    {
        switch ($metric) {
            case 'total_xp':
                return $user->userXp?->total_xp ?? 0;

            case 'quizzes_completed':
                return $user->quizHeaders()->where('completed', true)->count();

            case 'current_streak':
                return $user->userStreak?->current_streak ?? 0;

            case 'longest_streak':
                return $user->userStreak?->longest_streak ?? 0;

            case 'perfect_scores':
                return $user->quizHeaders()
                    ->where('completed', true)
                    ->whereRaw('score = quiz_size')
                    ->count();

            default:
                return 0;
        }
    }

    /**
     * Update ranks for all leaderboard entries
     */
    private function updateLeaderboardRanks(): void
    {
        $leaderboards = Leaderboard::where('is_active', true)->get();

        foreach ($leaderboards as $leaderboard) {
            $entries = LeaderboardEntry::where('leaderboard_id', $leaderboard->id)
                ->orderBy('score', 'desc')
                ->orderBy('last_updated', 'asc')
                ->get();

            $rank = 1;
            foreach ($entries as $entry) {
                $entry->update(['rank' => $rank]);
                $rank++;
            }
        }
    }

    /**
     * Award bonus XP (for badges, achievements, etc.)
     */
    private function awardXpBonus(User $user, int $amount, string $reason): void
    {
        $userXp = $user->userXp ?? new UserXp(['user_id' => $user->id, 'total_xp' => 0, 'level' => 1]);

        $userXp->total_xp += $amount;
        $userXp->level = $this->calculateLevel($userXp->total_xp);
        $userXp->save();

        XpTransaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'source' => 'bonus',
            'description' => $reason
        ]);
    }

    /**
     * Get user's current level info
     */
    public function getUserLevelInfo(User $user): array
    {
        $userXp = $user->userXp;

        if (!$userXp) {
            return [
                'level' => 1,
                'total_xp' => 0,
                'xp_for_next_level' => 100,
                'progress_percentage' => 0
            ];
        }

        $currentLevel = $userXp->level;
        $totalXp = $userXp->total_xp;

        // XP needed for current level = (level-1)^2 * 100
        $xpForCurrentLevel = (($currentLevel - 1) ** 2) * 100;
        // XP needed for next level = level^2 * 100
        $xpForNextLevel = ($currentLevel ** 2) * 100;

        $xpInCurrentLevel = $totalXp - $xpForCurrentLevel;
        $xpNeededForNextLevel = $xpForNextLevel - $xpForCurrentLevel;

        $progressPercentage = $xpNeededForNextLevel > 0
            ? round(($xpInCurrentLevel / $xpNeededForNextLevel) * 100, 1)
            : 100;

        return [
            'level' => $currentLevel,
            'total_xp' => $totalXp,
            'xp_for_next_level' => $xpNeededForNextLevel - $xpInCurrentLevel,
            'progress_percentage' => min(100, max(0, $progressPercentage))
        ];
    }
}

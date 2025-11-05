<?php

namespace App\Console\Commands;

use App\Models\AssessmentAttempt;
use Illuminate\Console\Command;

class CheckAssessmentData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-assessment-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check assessment attempt data and percentages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking assessment attempt data...');

        $userId = $this->ask('Enter user ID to check (or press enter for all users)', null);

        $query = AssessmentAttempt::with('assessment');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $attempts = $query->get();

        $attemptCount = $attempts->count();
        $this->info("Total assessment attempts" . ($userId ? " for user {$userId}" : "") . ": {$attemptCount}");

        $completedCount = $attempts->where('status', 'completed')->count();
        $this->info("Completed assessment attempts: {$completedCount}");

        if ($attemptCount > 0) {
            $this->info('Assessment attempts:');
            $attempts->each(function ($attempt) {
                $percentage = $attempt->percentage ?? 'NULL';
                $score = $attempt->score ?? 'NULL';
                $totalPoints = $attempt->total_points ?? 'NULL';
                $pointsEarned = $attempt->points_earned ?? 'NULL';
                $assessmentTitle = $attempt->assessment ? $attempt->assessment->title : 'N/A';
                $this->line("- ID: {$attempt->id}, User: {$attempt->user_id}, Assessment: {$assessmentTitle}, Status: {$attempt->status}, Percentage: {$percentage}%, Score: {$score}, Points: {$pointsEarned}/{$totalPoints}");
            });

            // Calculate average manually for completed attempts
            $completedAttempts = $attempts->where('status', 'completed');
            if ($completedAttempts->count() > 0) {
                $average = $completedAttempts->map(function ($attempt) {
                    return $attempt->percentage ?? 0;
                })->average();
                $this->info("Manual average calculation: " . number_format($average, 2) . "%");
            }
        } else {
            $this->warn('No assessment attempts found!');
        }

        return 0;
    }
}

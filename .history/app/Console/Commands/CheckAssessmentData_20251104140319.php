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

        $attemptCount = AssessmentAttempt::count();
        $this->info("Total assessment attempts: {$attemptCount}");

        $completedCount = AssessmentAttempt::where('status', 'completed')->count();
        $this->info("Completed assessment attempts: {$completedCount}");

        if ($attemptCount > 0) {
            $this->info('Assessment attempts:');
            AssessmentAttempt::with('assessment')->get()->each(function ($attempt) {
                $percentage = $attempt->percentage ?? 'NULL';
                $score = $attempt->score ?? 'NULL';
                $totalPoints = $attempt->total_points ?? 'NULL';
                $pointsEarned = $attempt->points_earned ?? 'NULL';
                $assessmentTitle = $attempt->assessment ? $attempt->assessment->title : 'N/A';
                $this->line("- ID: {$attempt->id}, Assessment: {$assessmentTitle}, Status: {$attempt->status}, Percentage: {$percentage}%, Score: {$score}, Points: {$pointsEarned}/{$totalPoints}");
            });

            // Calculate average manually
            $completedAttempts = AssessmentAttempt::where('status', 'completed')->get();
            if ($completedAttempts->count() > 0) {
                $average = $completedAttempts->map(function ($attempt) {
                    return $attempt->percentage ?? 0;
                })->average();
                $this->info("Manual average calculation: {$average}%");
            }
        } else {
            $this->warn('No assessment attempts found!');
        }

        return 0;
    }
}

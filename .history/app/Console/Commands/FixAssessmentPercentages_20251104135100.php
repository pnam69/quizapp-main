<?php

namespace App\Console\Commands;

use App\Models\AssessmentAttempt;
use Illuminate\Console\Command;

class FixAssessmentPercentages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-assessment-percentages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix assessment attempt percentages that are missing or incorrect';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Finding assessment attempts with missing or zero percentages...');

        $attempts = AssessmentAttempt::where(function ($query) {
            $query->whereNull('percentage')
                  ->orWhere('percentage', 0);
        })
        ->where('status', 'completed')
        ->with('attemptAnswers')
        ->get();

        $this->info("Found {$attempts->count()} attempts to fix");

        $bar = $this->output->createProgressBar($attempts->count());
        $bar->start();

        $fixed = 0;
        foreach ($attempts as $attempt) {
            $attempt->calculateResults();
            $fixed++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $this->info("Successfully fixed {$fixed} assessment attempts");
    }
}

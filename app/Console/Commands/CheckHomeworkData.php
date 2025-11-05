<?php

namespace App\Console\Commands;

use App\Models\Homework;
use App\Models\HomeworkSubmission;
use Illuminate\Console\Command;

class CheckHomeworkData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-homework-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check homework and homework submission data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking homework data...');

        $homeworkCount = Homework::count();
        $this->info("Total homework records: {$homeworkCount}");

        $submissionCount = HomeworkSubmission::count();
        $this->info("Total homework submissions: {$submissionCount}");

        $gradedCount = HomeworkSubmission::whereNotNull('graded_at')->count();
        $this->info("Graded homework submissions: {$gradedCount}");

        if ($homeworkCount > 0) {
            $this->info('Homework records:');
            Homework::all()->each(function ($homework) {
                $this->line("- ID: {$homework->id}, Title: {$homework->title}, Due: {$homework->due_date}");
            });
        }

        if ($submissionCount > 0) {
            $this->info('Homework submissions:');
            HomeworkSubmission::with('homework')->get()->each(function ($submission) {
                $graded = $submission->graded_at ? 'Yes (' . $submission->graded_at->format('Y-m-d H:i:s') . ')' : 'No';
                $homeworkTitle = $submission->homework ? $submission->homework->title : 'N/A';
                $this->line("- ID: {$submission->id}, Student: {$submission->student_id}, Homework: {$homeworkTitle}, Status: {$submission->status}, Graded: {$graded}");
            });
        } else {
            $this->warn('No homework submissions found!');
        }

        return 0;
    }
}

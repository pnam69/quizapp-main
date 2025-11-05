<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assessment;
use App\Models\AssessmentAttempt;
use App\Models\User;
use App\Models\Section;
use App\Models\Certification;
use Carbon\Carbon;

class AssessmentAttemptsSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting assessment attempts mock data seeding...');

        // Get all assessments and students
        $assessments = Assessment::where('is_published', true)->where('is_active', true)->get();
        $students = User::where('is_admin', 0)->where('is_active', 1)->get();

        if ($assessments->isEmpty()) {
            $this->command->error('No published assessments found. Please run MoreAssessmentsSeeder first.');
            return;
        }

        if ($students->isEmpty()) {
            $this->command->error('No students found. Please run MockDataSeeder first.');
            return;
        }

        $totalAttempts = 0;

        foreach ($assessments as $assessment) {
            $this->command->info("Creating attempts for assessment: {$assessment->title}");

            // 70-90% of students attempt each assessment
            $attemptingStudents = $students->random(
                (int) ($students->count() * (0.7 + rand(0, 20) / 100))
            );

            foreach ($attemptingStudents as $student) {
                // Create 1-3 attempts per student per assessment (some retake)
                $attemptCount = rand(1, 3);

                for ($attemptNumber = 1; $attemptNumber <= $attemptCount; $attemptNumber++) {
                    $this->createAssessmentAttempt($assessment, $student, $attemptNumber);
                    $totalAttempts++;
                }
            }
        }

        $this->command->info("✓ Successfully created {$totalAttempts} assessment attempts!");
        $this->command->info('Assessment attempts mock data seeding completed!');
    }

    private function createAssessmentAttempt(Assessment $assessment, User $student, int $attemptNumber)
    {
        // Calculate random score based on student performance pattern
        $baseScore = $this->getStudentPerformanceScore($student, $assessment);
        $attemptScore = $this->adjustScoreForAttempt($baseScore, $attemptNumber);

        // Calculate points earned based on score
        $pointsEarned = round(($attemptScore / 100) * $assessment->total_points);

        // Determine if passed
        $passed = $attemptScore >= $assessment->passing_score;

        // Calculate time taken (between 60% to 100% of time limit)
        $timePercentage = rand(60, 100) / 100;
        $timeTakenMinutes = round($assessment->time_limit * $timePercentage);

        // Set attempt dates (spread over last 60 days)
        $daysAgo = rand(1, 60);
        $startedAt = Carbon::now()->subDays($daysAgo)->setTime(rand(8, 18), rand(0, 59));
        $submittedAt = $startedAt->copy()->addMinutes($timeTakenMinutes);

        // Create the attempt
        AssessmentAttempt::create([
            'assessment_id' => $assessment->id,
            'user_id' => $student->id,
            'attempt_number' => $attemptNumber,
            'started_at' => $startedAt,
            'submitted_at' => $submittedAt,
            'time_taken' => $timeTakenMinutes,
            'score' => $attemptScore,
            'points_earned' => $pointsEarned,
            'total_points' => $assessment->total_points,
            'percentage' => $attemptScore,
            'passed' => $passed,
            'status' => 'completed',
            'answers' => $this->generateMockAnswers($assessment),
        ]);

        $this->command->info("  Created attempt #{$attemptNumber} for {$student->name}: {$attemptScore}% (" . ($passed ? 'PASSED' : 'FAILED') . ")");
    }

    private function getStudentPerformanceScore(User $student, Assessment $assessment): float
    {
        // Create a bell curve distribution: 30% high performers, 50% average, 20% struggling
        $performanceType = rand(1, 100);

        if ($performanceType <= 30) {
            // High performers: 70-100%
            $baseScore = rand(70, 100);
        } elseif ($performanceType <= 80) {
            // Average performers: 50-85%
            $baseScore = rand(50, 85);
        } else {
            // Struggling students: 30-65%
            $baseScore = rand(30, 65);
        }

        // Base performance varies by student year/classroom
        $yearMultiplier = match (true) {
            str_contains($student->email, '1st') => 0.85, // 1st year students: slightly lower
            str_contains($student->email, '2nd') => 0.95, // 2nd year: slightly lower
            str_contains($student->email, '3rd') => 1.10, // 3rd year: better performance
            str_contains($student->email, '4th') => 1.05, // 4th year: good performance
            default => 0.90
        };

        // Difficulty adjustment
        $difficultyMultiplier = match ($assessment->difficulty) {
            'easy' => 1.15,    // Easy tests: 15% bonus
            'medium' => 1.0,   // Medium: normal
            'hard' => 0.85,    // Hard: 15% penalty
            default => 1.0
        };

        // Category-based performance (some students better in certain subjects)
        $categoryBonus = $this->getCategoryBonus($student, $assessment->category);

        // Apply multipliers
        $finalScore = $baseScore * $yearMultiplier * $difficultyMultiplier * $categoryBonus;

        // Add some randomness (±10%) to make it more realistic
        $randomFactor = rand(-10, 10) / 100;
        $finalScore = $finalScore * (1 + $randomFactor);

        // Ensure score is within reasonable bounds
        return max(25, min(100, $finalScore));
    }

    private function getCategoryBonus(User $student, ?string $category): float
    {
        // Simulate students having strengths in certain categories
        $studentCategories = [
            'alice.cooper' => ['Web Development', 'Programming'],
            'bob.wilson' => ['Database', 'Cloud Computing'],
            'charlie.brown' => ['Web Development', 'Mobile Development'],
            'diana.prince' => ['Database', 'Programming'],
            'edward.norton' => ['Cloud Computing', 'Mobile Development'],
            'fiona.green' => ['Programming', 'Database'],
            'george.lucas' => ['Web Development', 'Cloud Computing'],
            'helen.troy' => ['Mobile Development', 'Programming'],
            'ian.malcolm' => ['Database', 'Web Development'],
            'julia.roberts' => ['Cloud Computing', 'Mobile Development'],
            'kevin.hart' => ['Programming', 'Web Development'],
            'laura.palmer' => ['Database', 'Cloud Computing'],
            'mike.tyson' => ['Mobile Development', 'Database'],
            'nina.simone' => ['Cloud Computing', 'Programming'],
            'oscar.wilde' => ['Web Development', 'Mobile Development'],
        ];

        $studentKey = strtolower(str_replace(['@student.edu', '.'], ['', '_'], $student->email));

        if ($category && isset($studentCategories[$studentKey]) && in_array($category, $studentCategories[$studentKey])) {
            return 1.20; // 20% bonus for strong categories (increased from 15%)
        }

        return 1.0; // No bonus
    }

    private function adjustScoreForAttempt(float $baseScore, int $attemptNumber): float
    {
        // First attempts might be lower, subsequent attempts improve significantly
        $adjustment = match ($attemptNumber) {
            1 => rand(-15, 0),   // First attempt: -15 to 0 (can be lower)
            2 => rand(5, 15),    // Second attempt: +5 to +15 (improvement)
            3 => rand(10, 20),   // Third attempt: +10 to +20 (significant improvement)
            default => 0
        };

        return max(35, min(100, $baseScore + $adjustment));
    }

    private function generateMockAnswers(Assessment $assessment): array
    {
        // Generate mock answers array for the attempt
        $answers = [];
        $questions = $assessment->questions;

        foreach ($questions as $question) {
            $options = $question->options;
            if ($options->isNotEmpty()) {
                // Randomly select an option (with bias toward correct answers for better scores)
                $correctOption = $options->where('is_correct', true)->first();
                $selectedOption = $correctOption ?? $options->random();

                if ($selectedOption) {
                    $answers[] = [
                        'question_id' => $question->id,
                        'selected_option_id' => $selectedOption->id,
                        'is_correct' => $selectedOption->is_correct,
                        'points_earned' => $selectedOption->is_correct ? $question->points : 0,
                    ];
                }
            }
        }

        return $answers;
    }
}

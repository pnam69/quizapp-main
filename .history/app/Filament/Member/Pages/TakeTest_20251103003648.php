<?php

namespace App\Filament\Member\Pages;

use App\Models\Assessment;
use App\Models\AssessmentAttempt;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class TakeTest extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Take Test';
    protected static ?string $title = 'Take a Test';
    protected static ?string $slug = 'take-test';
    protected static string $view = 'filament.member.pages.take-test';

    public $assessments = [];
    public $selectedAssessment = null;
    public $questions = [];
    public $answers = [];
    public $results = [];
    public $attemptStartTime = null;

    public function mount(): void
    {
        $user = Auth::user();
        
        // Get available assessments for the user
        $this->assessments = Assessment::where('status', 'published')
            ->where(function ($query) use ($user) {
                $query->whereNull('classroom_id')
                    ->orWhere('classroom_id', $user->classroom_id);
            })
            ->where(function ($query) {
                $query->whereNull('scheduled_at')
                    ->orWhere('scheduled_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('closes_at')
                    ->orWhere('closes_at', '>=', now());
            })
            ->with('questions.options')
            ->get()
            ->filter(fn($assessment) => $assessment->isAvailable() && $assessment->canUserAttempt($user));
    }

    public function selectTest($assessmentId): void
    {
        $this->selectedAssessment = Assessment::with('questions.options')->find($assessmentId);

        if (!$this->selectedAssessment) {
            $this->questions = collect();
            return;
        }

        // Check if user can attempt this assessment
        if (!$this->selectedAssessment->canUserAttempt(Auth::user())) {
            $this->questions = collect();
            $this->selectedAssessment = null;
            return;
        }

        // Get questions and shuffle if needed
        $this->questions = $this->selectedAssessment->questions;
        
        if ($this->selectedAssessment->shuffle_questions) {
            $this->questions = $this->questions->shuffle();
        }

        // Shuffle options if needed
        if ($this->selectedAssessment->shuffle_options) {
            $this->questions->each(function ($question) {
                $question->setRelation('options', $question->options->shuffle());
            });
        }

        $this->answers = [];
        $this->results = [];
        $this->attemptStartTime = now();
    }

    public function submit(): void
    {
        if (!$this->selectedAssessment) {
            return;
        }

        $this->results = [];
        $totalPoints = 0;
        $earnedPoints = 0;

        // Calculate results
        foreach ($this->questions as $question) {
            $chosen = $this->answers[$question->id] ?? null;
            $correctOption = $question->options->firstWhere('is_correct', true);
            $isCorrect = $chosen == ($correctOption->id ?? null);
            
            $totalPoints += $question->points;
            if ($isCorrect) {
                $earnedPoints += $question->points;
            }

            $this->results[$question->id] = [
                'userAnswer' => $chosen,
                'correctAnswer' => $correctOption->id ?? null,
                'isCorrect' => $isCorrect,
                'points' => $isCorrect ? $question->points : 0,
            ];
        }

        // Save attempt to database
        $attempt = AssessmentAttempt::create([
            'assessment_id' => $this->selectedAssessment->id,
            'user_id' => Auth::id(),
            'started_at' => $this->attemptStartTime,
            'submitted_at' => now(),
            'score' => $earnedPoints,
            'total_points' => $totalPoints,
            'passed' => $this->selectedAssessment->passing_score 
                ? ($earnedPoints / $totalPoints * 100) >= $this->selectedAssessment->passing_score
                : null,
        ]);

        // Save individual answers
        foreach ($this->results as $questionId => $result) {
            $attempt->answers()->create([
                'assessment_question_id' => $questionId,
                'selected_option_id' => $result['userAnswer'],
                'is_correct' => $result['isCorrect'],
                'points_earned' => $result['points'],
            ]);
        }
    }

    public function resetTest(): void
    {
        $this->selectedAssessment = null;
        $this->questions = [];
        $this->answers = [];
        $this->results = [];
        $this->attemptStartTime = null;
    }
}

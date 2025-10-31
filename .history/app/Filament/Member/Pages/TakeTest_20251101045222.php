<?php

namespace App\Filament\Member\Pages;

use App\Models\Test;
use App\Models\Question;
use Filament\Pages\Page;

class TakeTest extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Take Test';
    protected static ?string $title = 'Take a Test';
    protected static ?string $slug = 'take-test';
    protected static string $view = 'filament.member.pages.take-test';

    public $tests = [];
    public $selectedTest = null;
    public $questions = [];
    public $answers = [];
    public $results = [];

    public function mount(): void
    {
        $this->tests = Test::where('is_active', 1)->get();
    }

    public function selectTest($testId): void
    {
        $this->selectedTest = Test::find($testId);
        if (! $this->selectedTest) {
            $this->questions = collect();
            return;
        }

        // 1) Try direct relationship (most common)
        try {
            $questions = $this->selectedTest->questions()->with('answers')->get();
        } catch (\Throwable $e) {
            $questions = collect();
        }

        // 2) If nothing, try belongsToMany pivot pattern (question->tests)
        if ($questions->isEmpty()) {
            $questions = Question::whereHas('tests', function ($q) use ($testId) {
                $q->where('tests.id', $testId);
            })->with('answers')->get();
        }

        // 3) If still nothing, try questions table having test_id column
        if ($questions->isEmpty()) {
            $questions = Question::where('test_id', $testId)->with('answers')->get();
        }

        $this->questions = $questions;
        $this->answers = [];
        $this->results = [];
    }

    public function submit(): void
    {
        $this->results = [];

        foreach ($this->questions as $question) {
            $chosen = $this->answers[$question->id] ?? null;
            $correctAnswer = $question->answers->firstWhere('is_checked', 1);
            $this->results[$question->id] = [
                'chosen' => $chosen,
                'correct' => $correctAnswer->id ?? null,
                'isCorrect' => $chosen == ($correctAnswer->id ?? null),
            ];
        }
    }

    public function resetTest(): void
    {
        $this->selectedTest = null;
        $this->questions = collect();
        $this->answers = [];
        $this->results = [];
    }
}

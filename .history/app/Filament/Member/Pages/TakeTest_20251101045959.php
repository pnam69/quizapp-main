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
        // Load all active tests
        $this->tests = Test::where('is_active', 1)->get();
    }

    public function selectTest($testId): void
    {
        $this->selectedTest = Test::find($testId);

        if (!$this->selectedTest) {
            $this->questions = collect();
            return;
        }

        // Make sure question_ids is an array
        $questionIds = $this->selectedTest->question_ids;
        if (is_string($questionIds)) {
            $questionIds = json_decode($questionIds, true);
        }
        if (!is_array($questionIds)) {
            $questionIds = [];
        }

        // Load questions and eager load their answers
        $this->questions = Question::whereIn('id', $questionIds)
            ->with('answers')
            ->get()
            ->sortBy(function ($q) use ($questionIds) {
                // preserve the order from question_ids
                return array_search($q->id, $questionIds);
            })
            ->values();

        $this->answers = [];
        $this->results = [];
    }

    public function submit(): void
    {
        $this->results = [];

        foreach ($this->questions as $question) {
            $chosen = $this->answers[$question->id] ?? null;
            $correctOption = $question->answers->firstWhere('is_checked', 1);
            $this->results[$question->id] = [
                'chosen' => $chosen,
                'correct' => $correctOption->id ?? null,
                'isCorrect' => $chosen == ($correctOption->id ?? null),
            ];
        }
    }

    public function resetTest(): void
    {
        $this->selectedTest = null;
        $this->questions = [];
        $this->answers = [];
        $this->results = [];
    }
}

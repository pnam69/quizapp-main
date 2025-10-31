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

        if (!$this->selectedTest) {
            $this->questions = collect();
            return;
        }

        // decode JSON array to get question IDs
        $questionIds = json_decode($this->selectedTest->question_ids, true) ?? [];

        $this->questions = Question::whereIn('id', $questionIds)
            ->with('answers')
            ->get();

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

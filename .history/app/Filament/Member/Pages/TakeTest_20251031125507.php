<?php

namespace App\Filament\Member\Pages;

use App\Models\Test;
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
        $this->selectedTest = Test::findOrFail($testId);
        $this->questions = $this->selectedTest->questions()->with('options')->get();
        $this->answers = [];
        $this->results = [];
    }

    public function submit(): void
    {
        $this->results = [];

        foreach ($this->questions as $question) {
            $chosen = $this->answers[$question->id] ?? null;
            $correctOption = $question->options()->where('is_checked', 1)->first();
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

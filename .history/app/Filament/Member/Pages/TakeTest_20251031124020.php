<?php

namespace App\Filament\Member\Pages;

use App\Models\Test;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

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
    public $score = null;

    public function mount(): void
    {
        $this->tests = Test::where('is_active', 1)->get();
    }

    public function selectTest($testId): void
    {
        $this->selectedTest = Test::findOrFail($testId);
        // Load questions with related answers
        $this->questions = $this->selectedTest
            ->questions()
            ->with('answers') // make sure your Question model has `answers()` relation
            ->get();
        $this->answers = [];
        $this->score = null;
    }

    public function submit(): void
    {
        $correct = 0;
        $total = count($this->questions);

        foreach ($this->questions as $question) {
            $chosen = $this->answers[$question->id] ?? null;
            $correctOption = $question->answers()->where('is_checked', true)->first();

            if ($correctOption && $chosen == $correctOption->id) {
                $correct++;
            }
        }

        $this->score = $total ? round(($correct / $total) * 100, 2) : 0;

        $this->dispatch('notify', type: 'success', message: "You scored {$this->score}%");
    }

    public function resetTest(): void
    {
        $this->selectedTest = null;
        $this->questions = [];
        $this->answers = [];
        $this->score = null;
    }

    public function render(): View
    {
        return view(static::$view);
    }
}

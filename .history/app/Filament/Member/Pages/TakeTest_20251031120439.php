<?php

namespace App\Filament\Member\Pages;

use App\Models\Test;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class TakeTest extends Page
{
    protected static string $layout = '';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Take Test';
    protected static ?string $title = 'Take a Test';
    protected static ?string $slug = 'take-test';
    protected static string $view = 'filament.member.pages.take-test';

    public $tests = [];
    public $selectedTest = null;
    public $questions = [];
    public $answers = [];

    public function mount(): void
    {
        $this->tests = Test::where('is_active', 1)->get();
    }

    public function selectTest($testId): void
    {
        $this->selectedTest = Test::findOrFail($testId);
        $this->questions = $this->selectedTest->questions()->with('options')->get();
        $this->answers = [];
    }

    public function submit(): void
    {
        $correct = 0;
        $total = count($this->questions);

        foreach ($this->questions as $question) {
            $chosen = $this->answers[$question->id] ?? null;
            $correctOption = $question->options()->where('is_correct', true)->first();

            if ($correctOption && $chosen == $correctOption->id) {
                $correct++;
            }
        }

        $score = $total ? round(($correct / $total) * 100, 2) : 0;

        $this->dispatch('notify', type: 'success', message: "You scored {$score}%");

        $this->reset(['selectedTest', 'questions', 'answers']);
        $this->mount(); // reload available tests
    }

    public function render(): View
    {
        return view(static::$view);
    }
}

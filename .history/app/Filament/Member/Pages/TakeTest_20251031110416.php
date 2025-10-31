<?php

namespace App\Filament\Member\Pages;

use App\Models\Quiz;
use Filament\Pages\Page;

class TakeTest extends Page
{
    public $quiz;
    public $questions;
    public $currentQuestionIndex = 0;
    public $currentQuestion;
    public $answers = [];

    protected static string $view = 'filament.member.pages.take-test';

    public function mount($record): void
    {
        $this->quiz = Quiz::with('questions')->findOrFail($record);

        // Load questions via relationship
        $this->questions = $this->quiz->questions;

        if ($this->questions->isNotEmpty()) {
            $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
        }
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
            $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
        }
    }

    public function render()
    {
        return view(static::$view, [
            'quiz' => $this->quiz,
            'currentQuestion' => $this->currentQuestion,
        ]);
    }
}

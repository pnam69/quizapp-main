<?php

namespace App\Filament\Member\Pages;

use App\Models\QuizHeader;
use Filament\Pages\Page;

class TakeTest extends Page
{
    public $quizHeader;
    public $questions;
    public $currentQuestionIndex = 0;
    public $currentQuestion;

    protected static string $view = 'filament.member.pages.take-test';

    public function mount($record): void
    {
        $this->quizHeader = QuizHeader::with('questions')->findOrFail($record);

        $this->questions = $this->quizHeader->questions;

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
            'quizHeader' => $this->quizHeader,
            'currentQuestion' => $this->currentQuestion,
        ]);
    }
}

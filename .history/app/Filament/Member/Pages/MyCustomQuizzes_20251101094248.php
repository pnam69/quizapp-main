<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use App\Models\MyQuizzes as MyQuizzesModel;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class MyCustomQuizzes extends Page
{
    protected static string $view = 'filament.member.pages.my-custom-quizzes';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'My Quizzes';
    protected static ?string $slug = 'my-custom-quizzes';
    protected static ?int $navigationSort = 3;

    public $quizzes = [];
    public $selectedQuiz = null;
    public $currentQuestionIndex = 0;
    public $answers = [];
    public $showResults = false;
    public $score = 0;
    public $totalQuestions = 0;

    public function mount(): void
    {
        $this->loadQuizzes();
    }

    public function loadQuizzes(): void
    {
        $user = Auth::guard('member')->user();
        if ($user) {
            $this->quizzes = MyQuizzesModel::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function selectQuiz($quizId): void
    {
        $quiz = MyQuizzesModel::find($quizId);

        if (!$quiz) {
            Notification::make()
                ->title('Quiz Not Found')
                ->danger()
                ->send();
            return;
        }

        $this->selectedQuiz = $quiz;
        $this->currentQuestionIndex = 0;
        $this->answers = [];
        $this->showResults = false;
        $this->score = 0;
        $this->totalQuestions = count($quiz->questions ?? []);
    }

    public function answerQuestion($optionIndex): void
    {
        if (!$this->selectedQuiz) {
            return;
        }

        $this->answers[$this->currentQuestionIndex] = $optionIndex;
    }

    public function nextQuestion(): void
    {
        if ($this->currentQuestionIndex < $this->totalQuestions - 1) {
            $this->currentQuestionIndex++;
        }
    }

    public function previousQuestion(): void
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }

    public function submitQuiz(): void
    {
        if (!$this->selectedQuiz) {
            return;
        }

        // Check if all questions are answered
        if (count($this->answers) < $this->totalQuestions) {
            Notification::make()
                ->title('Incomplete Quiz')
                ->body('Please answer all questions before submitting.')
                ->warning()
                ->send();
            return;
        }

        // Calculate score
        $correctAnswers = 0;
        $questions = $this->selectedQuiz->questions;

        foreach ($questions as $questionIndex => $question) {
            if (isset($this->answers[$questionIndex])) {
                $selectedOptionIndex = $this->answers[$questionIndex];
                if (
                    isset($question['options'][$selectedOptionIndex]) &&
                    ($question['options'][$selectedOptionIndex]['is_correct'] ?? false)
                ) {
                    $correctAnswers++;
                }
            }
        }

        $this->score = $this->totalQuestions > 0
            ? round(($correctAnswers / $this->totalQuestions) * 100, 2)
            : 0;

        $this->showResults = true;

        Notification::make()
            ->title('Quiz Completed!')
            ->body("You scored {$this->score}% ({$correctAnswers}/{$this->totalQuestions} correct)")
            ->success()
            ->send();
    }

    public function resetQuiz(): void
    {
        $this->selectedQuiz = null;
        $this->currentQuestionIndex = 0;
        $this->answers = [];
        $this->showResults = false;
        $this->score = 0;
        $this->totalQuestions = 0;
    }

    public function deleteQuiz($quizId): void
    {
        $quiz = MyQuizzesModel::find($quizId);

        if (!$quiz) {
            Notification::make()
                ->title('Quiz Not Found')
                ->danger()
                ->send();
            return;
        }

        // Check if user owns this quiz
        $user = Auth::guard('member')->user();
        if ($quiz->user_id !== $user->id) {
            Notification::make()
                ->title('Unauthorized')
                ->body('You can only delete your own quizzes.')
                ->danger()
                ->send();
            return;
        }

        $quizTitle = $quiz->title;
        $quiz->delete();

        Notification::make()
            ->title('Quiz Deleted')
            ->body("Quiz '{$quizTitle}' has been deleted.")
            ->success()
            ->send();

        $this->loadQuizzes();

        if ($this->selectedQuiz && $this->selectedQuiz->id === $quizId) {
            $this->resetQuiz();
        }
    }

    public function getCurrentQuestion()
    {
        if (!$this->selectedQuiz || !isset($this->selectedQuiz->questions[$this->currentQuestionIndex])) {
            return null;
        }

        return $this->selectedQuiz->questions[$this->currentQuestionIndex];
    }

    public function getSelectedAnswer()
    {
        return $this->answers[$this->currentQuestionIndex] ?? null;
    }
}

<?php

namespace App\Filament\Member\Pages;

use App\Models\QuizHeader;
use App\Models\QuizAnswer;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class TakeTest extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Take Test';
    protected static ?string $title = 'Take a Test';
    protected static ?string $slug = 'take-test';
    protected static string $view = 'filament.member.pages.take-test';

    public $quizzes = [];
    public $selectedQuiz = null;
    public $questions = [];
    public $answers = [];

    public function mount()
    {
        $user = Auth::guard('member')->user();
        $sectionIds = $user->sections()->pluck('id');
        $certificationIds = $user->certifications()->pluck('id');

        $this->quizzes = QuizHeader::whereIn('section_id', $sectionIds)
            ->orWhereIn('certification_id', $certificationIds)
            ->get();
    }

    public function selectQuiz($quizId)
    {
        $this->selectedQuiz = QuizHeader::findOrFail($quizId);

        // Load questions with answers
        $this->questions = $this->selectedQuiz->questions()->with('answers')->get();

        // Initialize answers array for Livewire binding
        $this->answers = [];
        foreach ($this->questions as $q) {
            $this->answers[$q->id] = null;
        }
    }

    public function submit()
    {
        $userId = Auth::guard('member')->id();
        $correct = 0;

        foreach ($this->questions as $question) {
            $chosenAnswerId = $this->answers[$question->id] ?? null;
            if (!$chosenAnswerId) continue;

            $answer = $question->answers()->find($chosenAnswerId);
            if (!$answer) continue;

            if ($answer->is_checked) $correct++;

            // Save to quiz_answers table
            QuizAnswer::updateOrCreate(
                [
                    'user_id' => $userId,
                    'quiz_header_id' => $this->selectedQuiz->id,
                    'question_id' => $question->id,
                ],
                [
                    'answer_id' => $chosenAnswerId,
                    'is_correct' => $answer->is_checked,
                ]
            );
        }

        $total = count($this->questions);
        $score = $total ? round(($correct / $total) * 100, 2) : 0;

        // Update quiz record for this user
        $this->selectedQuiz->update([
            'score' => $score,
            'completed' => true,
        ]);

        $this->dispatch('notify', type: 'success', message: "You scored {$score}%");

        $this->reset(['selectedQuiz', 'questions', 'answers']);
        $this->mount();
    }
}

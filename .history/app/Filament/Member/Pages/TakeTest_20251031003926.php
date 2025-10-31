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
        $this->questions = $this->selectedQuiz->questions()->with('answers')->get();
        $this->answers = [];
    }

    public function submit()
    {
        $correct = 0;
        $total = count($this->questions);

        foreach ($this->questions as $question) {
            $chosen = $this->answers[$question->id] ?? null;
            $answer = $question->answers()->where('is_checked', true)->first();
            if ($answer && $answer->id == $chosen) {
                $correct++;
            }
        }

        $score = $total ? round(($correct / $total) * 100, 2) : 0;

        $this->selectedQuiz->update(['score' => $score, 'completed' => true]);

        // Save each answer to QuizAnswer
        $user = Auth::guard('member')->user();
        $quiz = $this->selectedQuiz;
        foreach ($this->answers as $questionId => $optionId) {
            $option = \App\Models\Option::find($optionId);

            \App\Models\QuizAnswer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'quiz_header_id' => $quiz->id,
                    'question_id' => $questionId,
                ],
                [
                    'option_id' => $optionId,
                    'is_correct' => $option?->is_correct ?? false,
                ]
            );
        }

        $this->dispatch('notify', type: 'success', message: "You scored {$score}%");
        $this->reset(['selectedQuiz', 'questions', 'answers']);
        $this->mount(); // refresh quiz list

    }
}

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
        $user = Auth::guard('member')->user();
        $correct = 0;
        $total = count($this->questions);

        foreach ($this->questions as $question) {
            $chosenOptionId = $this->answers[$question->id] ?? null;

            if (!$chosenOptionId) continue;

            $option = $question->options()->find($chosenOptionId);
            $isCorrect = $option ? $option->is_correct : false;

            // Count correct answers
            if ($isCorrect) $correct++;

            // Save to quiz_answers table
            \App\Models\QuizAnswer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'quiz_header_id' => $this->selectedQuiz->id,
                    'question_id' => $question->id,
                ],
                [
                    'option_id' => $chosenOptionId,
                    'is_correct' => $isCorrect,
                ]
            );
        }

        $score = $total ? round(($correct / $total) * 100, 2) : 0;

        $this->selectedQuiz->update([
            'score' => $score,
            'completed' => true,
        ]);

        $this->dispatch('notify', type: 'success', message: "You scored {$score}%");
        $this->reset(['selectedQuiz', 'questions', 'answers']);
        $this->mount(); // refresh quiz list
    }
}

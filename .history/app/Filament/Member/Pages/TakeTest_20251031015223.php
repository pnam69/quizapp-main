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
            // Ensure the user selected an answer
            $chosenAnswerId = $this->answers[$question->id] ?? null;
            if (!$chosenAnswerId) {
                // skip if no answer was selected
                continue;
            }

            // Load the answer and check correctness
            $answer = $question->answers()->find($chosenAnswerId);
            if (!$answer) {
                // skip if the answer ID is invalid
                continue;
            }
            $isCorrect = $answer->is_checked;

            // Save or update the quiz answer
            QuizAnswer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'quiz_header_id' => $this->selectedQuiz->id,
                    'question_id' => $question->id,
                ],
                [
                    'answer_id' => $chosenAnswerId,
                    'is_correct' => $isCorrect,
                ]
            );

            if ($isCorrect) $correct++;
        }

        // Calculate score
        $score = $total ? round(($correct / $total) * 100, 2) : 0;

        // Update quiz attempt record
        $this->selectedQuiz->update([
            'score' => $score,
            'completed' => true,
        ]);

        $this->dispatch('notify', type: 'success', message: "You scored {$score}%");

        $this->reset(['selectedQuiz', 'questions', 'answers']);
        $this->mount();
    }
}

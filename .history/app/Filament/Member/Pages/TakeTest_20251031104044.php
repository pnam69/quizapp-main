<?php

namespace App\Filament\Member\Pages;

use App\Models\QuizHeader;
use App\Models\Question;
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

        // load quizzes assigned to user
        $this->quizzes = QuizHeader::whereIn('section_id', $sectionIds)
            ->orWhereIn('certification_id', $certificationIds)
            ->get();
    }

    public function selectQuiz($quizId)
    {
        $this->selectedQuiz = QuizHeader::findOrFail($quizId);

        // load questions based on the 'questions_taken' JSON array
        $questionIds = $this->selectedQuiz->questions_taken ?? [];
        $this->questions = Question::whereIn('id', $questionIds)->get();

        $this->answers = [];
    }

    public function submit()
    {
        $correct = 0;
        $total = count($this->questions);

        foreach ($this->questions as $question) {
            $chosen = $this->answers[$question->id] ?? null;

            // check against the correct answer
            $answer = $question->options()->where('is_correct', true)->first();
            if ($answer && $answer->id == $chosen) {
                $correct++;
            }
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

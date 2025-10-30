<?php

namespace App\Filament\Member\Pages;

use App\Models\QuizHeader;
use Illuminate\Support\Facades\Auth;
use Filament\Pages\Page;

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
        $user = Auth::user();

        $sectionIds = $user->sections()->pluck('sections.id');
        $certificationIds = $user->certifications()->pluck('certifications.id');

        // Use QuizHeader instead of Quiz
        $this->quizzes = QuizHeader::query()
            ->whereIn('section_id', $sectionIds)
            ->orWhereIn('certification_id', $certificationIds)
            ->get();
    }

    public function selectQuiz($quizId)
    {
        $this->selectedQuiz = QuizHeader::find($quizId);

        // Link questions by domain or other method you use
        $this->questions = \App\Models\Question::where('domain_id', $this->selectedQuiz->domain_id)->get();
        $this->answers = [];
    }

    public function submit()
    {
        $correct = 0;
        $total = count($this->questions);

        foreach ($this->questions as $question) {
            $chosen = $this->answers[$question->id] ?? null;
            $answer = \App\Models\Answer::where('question_id', $question->id)
                ->where('is_correct', true)
                ->first();

            if ($answer && $answer->id == $chosen) {
                $correct++;
            }
        }

        $score = $total ? round(($correct / $total) * 100, 2) : 0;

        $this->selectedQuiz->update(['score' => $score, 'completed' => true]);

        $this->dispatch('notify', type: 'success', message: "You scored {$score}%");
        $this->reset(['selectedQuiz', 'questions', 'answers']);
        $this->mount();
    }
}

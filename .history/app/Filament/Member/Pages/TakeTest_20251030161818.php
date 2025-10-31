<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Filament\Pages\Actions\Action;
use App\Models\QuizHeader;
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

    public function mount(): void
    {
        $user = Auth::guard('member')->user();

        $sectionIds = $user->sections()->pluck('sections.id');
        $certificationIds = $user->certifications()->pluck('certifications.id');

        $this->quizzes = QuizHeader::query()
            ->whereIn('section_id', $sectionIds)
            ->orWhereIn('certification_id', $certificationIds)
            ->get();
    }

    protected function getHeaderActions(): array
    {
        // Example of starting test from header if needed
        return [];
    }

    public function startTest(int $quizId): void
    {
        $this->selectedQuiz = QuizHeader::find($quizId);
        $this->questions = \App\Models\Question::where('domain_id', $this->selectedQuiz->domain_id)->get();
        $this->answers = [];
    }

    public function submitTest(): void
    {
        $correct = 0;
        foreach ($this->questions as $question) {
            $chosen = $this->answers[$question->id] ?? null;
            $answer = \App\Models\Answer::where('question_id', $question->id)
                ->where('is_correct', true)
                ->first();

            if ($answer && $answer->id == $chosen) {
                $correct++;
            }
        }

        $score = count($this->questions) ? round(($correct / count($this->questions)) * 100, 2) : 0;

        $this->selectedQuiz->update([
            'score' => $score,
            'completed' => true,
        ]);

        $this->selectedQuiz = null;
        $this->questions = [];
        $this->answers = [];
    }
}

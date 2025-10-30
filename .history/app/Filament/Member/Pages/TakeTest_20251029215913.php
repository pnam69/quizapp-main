<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use App\Models\QuizHeader;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
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
        $user = Auth::user();

        // Get the IDs of sections and certifications the user belongs to
        $sectionIds = $user->sections()->pluck('sections.id')->toArray();
        $certificationIds = $user->certifications()->pluck('certifications.id')->toArray();

        // Get quizzes (quiz headers) assigned to those sections or certifications
        $this->quizzes = QuizHeader::query()
            ->whereIn('section_id', $sectionIds)
            ->orWhereIn('certification_id', $certificationIds)
            ->with(['section', 'certification'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function selectQuiz($quizId)
    {
        $this->selectedQuiz = QuizHeader::find($quizId);

        if (!$this->selectedQuiz) {
            $this->dispatch('notify', type: 'error', message: 'Quiz not found.');
            return;
        }

        // Get all questions linked to this quiz header through quizzes table
        $this->questions = Question::whereHas('quizzes', function ($query) use ($quizId) {
            $query->where('quiz_header_id', $quizId);
        })->get();

        $this->answers = [];
    }

    public function submit()
    {
        if (!$this->selectedQuiz) {
            $this->dispatch('notify', type: 'error', message: 'No quiz selected.');
            return;
        }

        $correct = 0;
        $total = count($this->questions);

        foreach ($this->questions as $question) {
            $chosen = $this->answers[$question->id] ?? null;
            $answer = Answer::where('question_id', $question->id)
                ->where('is_correct', true)
                ->first();

            if ($answer && $answer->id == $chosen) {
                $correct++;
            }
        }

        $score = $total ? round(($correct / $total) * 100, 2) : 0;

        // Update the quiz header record for this user attempt
        $this->selectedQuiz->update([
            'user_id' => Auth::id(),
            'score' => $score,
            'completed' => true,
        ]);

        $this->dispatch('notify', type: 'success', message: "You scored {$score}%");

        // Reset state
        $this->reset(['selectedQuiz', 'questions', 'answers']);
        $this->mount();
    }
}

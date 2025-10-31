<?php

namespace App\Filament\Member\Pages;

use App\Models\QuizHeader;
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
    public $selectedQuiz = null; // model or null
    public $questions = [];      // collection of Question models
    public $answers = [];        // keyed by question id => answer id

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

    public function resetQuiz()
    {
        $this->reset(['selectedQuiz', 'questions', 'answers']);
        $this->mount(); // refresh list
    }

    public function submit()
    {
        $correct = 0;
        $total = count($this->questions);

        foreach ($this->questions as $question) {
            $chosen = $this->answers[$question->id] ?? null;
            if (!$chosen) {
                // unanswered → skip counting but still allowed
                continue;
            }

            // check correctness using answers table
            $answer = $question->answers()->where('id', $chosen)->first();
            if ($answer && ($answer->is_checked || $answer->is_correct ?? false)) {
                $correct++;
            }
        }

        $score = $total ? round(($correct / $total) * 100, 2) : 0;

        // Persist to quiz header (shows up on MyResults)
        $this->selectedQuiz->update(['score' => $score, 'completed' => true]);

        $this->dispatch('notify', type: 'success', message: "You scored {$score}%");

        // reset component into list view
        $this->reset(['selectedQuiz', 'questions', 'answers']);
        $this->mount(); // refresh quiz list
    }
}

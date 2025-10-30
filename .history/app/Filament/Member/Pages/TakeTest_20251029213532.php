<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
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
    
    public function mount()
    {
        // Fetch quizzes assigned to this student's classroom
        $user = Auth::user();

        $sectionIds = $user->sections()->pluck('sections.id');
        $certificationIds = $user->certifications()->pluck('certifications.id');

        $this->quizzes = QuizHeader::query()
            ->whereIn('section_id', $user->sections()->pluck('sections.id'))
            ->orWhereIn('certification_id', $user->certifications()->pluck('certifications.id'))
            ->get();
    }

    public function selectQuiz($quizId)
    {
        $this->selectedQuiz = Quiz::find($quizId);
        $this->questions = Question::where('quiz_id', $quizId)->get();
        $this->answers = [];
    }

    
    public function submit()
    {
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

        QuizHeader::create([
            'user_id' => Auth::id(),
            'quiz_id' => $this->selectedQuiz->id,
            'score' => $score,
        ]);

        $this->dispatch('notify', type: 'success', message: "You scored {$score}%");
        $this->reset(['selectedQuiz', 'questions', 'answers']);
        $this->mount(); // Reload quizzes
    }
}

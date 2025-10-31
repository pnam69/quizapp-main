<?php

namespace App\Filament\Member\Pages;

use App\Models\QuizHeader;
use App\Models\QuizAnswer;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
    public $answers = []; // keyed by question id => answer id
    public $result = null; // keep last score if we want to show it

    public function mount()
    {
        $user = Auth::guard('member')->user();
        if (! $user) {
            $this->quizzes = collect();
            return;
        }

        $sectionIds = $user->sections()->pluck('id')->toArray();
        $certificationIds = $user->certifications()->pluck('id')->toArray();

        $this->quizzes = QuizHeader::query()
            ->whereIn('section_id', $sectionIds ?: [-1])
            ->orWhereIn('certification_id', $certificationIds ?: [-1])
            ->get();
    }

    public function selectQuiz($quizId)
    {
        $this->selectedQuiz = QuizHeader::findOrFail($quizId);

        // Defensive: if pivot table or answers table not present, return empty questions
        if (! Schema::hasTable('quiz_header_question') || ! Schema::hasTable('questions')) {
            $this->questions = collect();
            return;
        }

        // load questions; your questions table column is `question` and answers table is `answers` with columns `id, answer, is_checked, question_id`
        $this->questions = $this->selectedQuiz->questions()->with('answers')->get();

        // init answers array for wiring (null => not selected)
        $this->answers = [];
        foreach ($this->questions as $q) {
            $this->answers[$q->id] = null;
        }

        $this->result = null;
    }

    public function submit()
    {
        // Guard
        $user = Auth::guard('member')->user();
        if (! $user || ! $this->selectedQuiz) {
            $this->dispatch('notify', type: 'danger', message: 'No quiz selected or user not authenticated.');
            return;
        }

        // If quiz_answers table missing, just compute score and update header (no persistence)
        $canPersist = Schema::hasTable('quiz_answers');

        $correct = 0;
        $total = $this->questions->count();

        DB::beginTransaction();
        try {
            foreach ($this->questions as $question) {
                $chosenAnswerId = $this->answers[$question->id] ?? null;
                if (! $chosenAnswerId) {
                    // not answered, skip
                    continue;
                }

                // load the Answer model (answers table column is `answer`)
                $answer = $question->answers()->find($chosenAnswerId);
                if (! $answer) continue;
                $isCorrect = (bool) $answer->is_checked;

                if ($isCorrect) $correct++;

                if ($canPersist) {
                    // create/update quiz_answers row
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
                }
            }

            $score = $total ? round(($correct / $total) * 100, 2) : 0;

            // update quiz header score/completed — this is how MyResults picks it up
            $this->selectedQuiz->update([
                'score' => $score,
                'completed' => true,
            ]);

            DB::commit();

            $this->result = [
                'score' => $score,
                'correct' => $correct,
                'total' => $total,
            ];

            $this->dispatch('notify', type: 'success', message: "You scored {$score}%");
        } catch (\Throwable $e) {
            DB::rollBack();
            // log or return
            $this->dispatch('notify', type: 'danger', message: 'Error saving answers: ' . $e->getMessage());
        }

        // keep selectedQuiz/questions so user can see review (don't reset automatically)
    }
}

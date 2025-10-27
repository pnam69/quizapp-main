<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Answer;
use App\Models\Certification;
use App\Models\Domain;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizHeader;
use App\Models\Quote;
use App\Models\Test; // <-- added
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Get;
use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\HtmlString;

class UserQuiz extends Component implements HasForms
{
    use InteractsWithForms;

    public $quote = '';
    public $domains = [];
    public $domain_id = '';
    public $difficulty = [];
    public $section_id = '';
    public $certification_id = '';
    public $userAnswered = '';
    public $quizPecentage = 0;
    public $currentQuizSize = 0;
    public $learningMode = false;
    public $quizHasEnded = false;
    public $quizInProgress = false;
    public $totalQuizQuestions = 0;
    public $currectQuizAnswers = 0;
    public $answeredQuestionId = '';
    public $answeredQuestions = [];
    public $quizQuestionCounter = 1;
    public $quizSetupInProgress = true;
    public $isUserAnswerCorrect = false;

    public ?Question $currentQuestion = null;               // nullable now
    public ?QuizHeader $currentquizHeader = null;           // nullable now
    public ?Certification $certification = null;            // nullable now

    public $test_id; // declared to bind to the preQuiz form

    public function mount()
    {
        $this->quote = Quote::where('is_active', true)->inRandomOrder()->first();
    }

    public function render()
    {
        return view('livewire.user-quiz');
    }

    public function initializeQuiz(): void
    {
        // validate the preQuiz form state
        $this->preQuizForm->validate();

        // Fetch the selected Test record
        $test = Test::with('certification')->find($this->test_id);

        if (!$test || empty($test->question_ids) || count($test->question_ids) === 0) {
            Notification::make()
                ->title('Cannot start test')
                ->warning()
                ->body('This test has no questions assigned.')
                ->send();
            return;
        }

        $size = count($test->question_ids);

        // Create a new QuizHeader (test attempt)
        $this->currentquizHeader = QuizHeader::create([
            'user_id' => auth()->id(),
            'certification_id' => $test->certification_id,
            'section_id' => $test->certification->section_id ?? null,
            'quiz_size' => $size,
            'test_id' => $test->id,
            'current_index' => 0, // start at first question
            'learningmode' => false,
            'completed' => false,
        ]);

        // Initialize tracking variables
        $this->answeredQuestions = [];
        $this->quizQuestionCounter = 1;
        $this->quizSetupInProgress = false;
        $this->quizInProgress = true;
        $this->currentQuizSize = $size;

        // Load the first question
        $firstQuestionId = $test->question_ids[0];
        $this->currentQuestion = Question::with('answers')->find($firstQuestionId);
    }

    public function startQuiz()
    {
        // ensure we validate the quiz answer form
        $this->quizForm->validate();

        if (!$this->currentQuestion || !$this->currentquizHeader) {
            $this->addError('currentQuestion', 'No question loaded.');
            return;
        }

        // find correct answer robustly (support either column name used)
        $correctAnswer = Answer::where('question_id', $this->currentQuestion->id)
            ->where(function ($q) {
                $q->where('is_checked', true)
                  ->orWhere('is_correct', true);
            })
            ->first();

        $userAnswered = Answer::where('question_id', $this->currentQuestion->id)
            ->where('id', $this->answeredQuestionId)
            ->first();

        $isAnswerCorrect = false;
        if ($userAnswered && $correctAnswer) {
            $isAnswerCorrect = ($correctAnswer->id === $userAnswered->id);
        }

        // record the answer
        Quiz::create([
            'user_id' => auth()->id(),
            'quiz_header_id' => $this->currentquizHeader->id,
            'section_id' => $this->currentquizHeader->section_id,
            'question_id' => $this->currentQuestion->id,
            'domain_id' => optional($this->currentQuestion->domain)->id,
            'certification_id' => $this->currentquizHeader->certification_id,
            'answer_id' => $this->answeredQuestionId,
            'is_correct' => $isAnswerCorrect,
        ]);

        // append current question to answered list (source-of-truth for UI/trace)
        $this->answeredQuestions[] = $this->currentQuestion->id;

        // increment header index (DB-level increment to reduce race conditions)
        $this->currentquizHeader->increment('current_index');
        $this->currentquizHeader->questions_taken = $this->answeredQuestions;
        $this->currentquizHeader->save();

        // check if finished
        $nextIndex = $this->currentquizHeader->current_index;
        if ($nextIndex >= $this->currentQuizSize) {
            $this->showResults();
            return;
        }

        // reset selection and load next question
        $this->answeredQuestionId = null;
        $this->currentQuestion = $this->getNewQuestion();
        $this->quizQuestionCounter = $nextIndex + 1; // human-facing counter (1-based)
    }

    public function getNewQuestion()
    {
        if (!$this->currentquizHeader || !$this->currentquizHeader->test_id) {
            return null;
        }

        $test = Test::find($this->currentquizHeader->test_id);

        // next index is taken from header
        $nextIndex = $this->currentquizHeader->current_index;

        if ($nextIndex === null || $nextIndex >= count($test->question_ids)) {
            $this->showResults();
            return null;
        }

        $nextQuestionId = $test->question_ids[$nextIndex] ?? null;
        if (!$nextQuestionId) {
            $this->showResults();
            return null;
        }

        $question = Question::with('answers')->find($nextQuestionId);

        return $question;
    }

    public function showResults()
    {
        if (!$this->currentquizHeader) {
            return;
        }

        $total = Quiz::where('quiz_header_id', $this->currentquizHeader->id)->count();
        $correct = Quiz::where('quiz_header_id', $this->currentquizHeader->id)
            ->where('is_correct', '1')
            ->count();

        $this->totalQuizQuestions = $total;
        $this->currectQuizAnswers = $correct;
        $this->quizPecentage = $total ? round(($correct / $total) * 100, 2) : 0;

        $this->currentquizHeader->questions_taken = $this->answeredQuestions;
        $this->currentquizHeader->completed = true;
        $this->currentquizHeader->score = $this->quizPecentage;
        $this->currentquizHeader->finished_at = now();
        $this->currentquizHeader->save();

        $this->quizInProgress = false;
        $this->quizHasEnded = true;
    }

    protected function getForms(): array
    {
        return [
            'preQuizForm',
            'quizForm',
        ];
    }

    public function preQuizForm(Form $form): Form
    {
        return $form
            ->schema([
                ComponentsSection::make('Quiz Configuration')
                    ->schema([
                        Wizard::make([
                            Wizard\Step::make('Certification')
                                ->schema([
                                    Select::make('test_id')
                                        ->label('Select Test')
                                        ->options(Test::where('is_active', true)->pluck('name', 'id'))
                                        ->required()
                                        ->live()
                                        ->native(false),

                                    Select::make('certification_id')
                                        ->label('Certification')
                                        ->options(
                                            Auth::user()->certifications_owned->pluck('name', 'id')
                                        )
                                        ->required()
                                        ->live()
                                        ->native(false),

                                    Select::make('domains')
                                        ->label('Domains to Include')
                                        ->options(fn(Get $get): Collection => Domain::query()
                                            ->where('certification_id', $get('certification_id'))
                                            ->pluck('name', 'id'))
                                        ->required()
                                        ->multiple()
                                        ->live()
                                        ->native(false),
                                ]),
                            Wizard\Step::make('Quiz Mode (Learning / Live)')
                                ->schema([
                                    Toggle::make('learningMode')
                                        ->label('Learning Mode on?')
                                        ->onColor('success')
                                        ->offColor('gray'),

                                    CheckboxList::make('difficulty')
                                        ->label('Difficulty Level')
                                        ->options([
                                            1 => 'Easy',
                                            2 => 'Medium',
                                            3 => 'Hard',
                                        ])->columns(5)
                                        ->required(),
                                ]),
                            Wizard\Step::make('Levels')
                                ->schema([
                                    Select::make('currentQuizSize')
                                        ->label('Quiz Size')
                                        ->options([
                                            5 => '5',
                                            10 => '10',
                                            15 => '15',
                                        ])
                                        ->native(false),
                                ]),
                        ])->submitAction(new HtmlString('<button class="btn-primary" type="submit">Start Quiz</button>')),
                    ]),
            ])
            ->model(QuizHeader::class);
    }

    public function quizForm(Form $form): Form
    {
        return $form
            ->schema([
                Radio::make('answeredQuestionId')
                    ->label('Answers')
                    ->options(fn() => Answer::where('question_id', $this->currentQuestion->id)
                        ->pluck('answer', 'id'))
                    ->required(),
            ])
            ->model(Quiz::class);
    }
}

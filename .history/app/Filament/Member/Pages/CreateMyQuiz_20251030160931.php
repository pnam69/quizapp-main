<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\MyQuizzes;

class CreateMyQuiz extends Page implements HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $view = 'filament.member.pages.create-my-quiz';
    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?string $navigationLabel = 'Create Quiz';
    protected static ?string $slug = 'create-my-quiz';

    public ?string $quizTitle = null;
    public ?int $quiz_size = 0;
    public array $questions = [];

    public function mount(): void
    {
        // Pre-fill form
        if (empty($this->questions)) {
            $this->questions = [
                [
                    'question_text' => '',
                    'options' => [
                        ['option_text' => '', 'is_correct' => false],
                        ['option_text' => '', 'is_correct' => false],
                    ],
                ],
            ];
        }

        $this->form->fill([
            'quizTitle' => $this->quizTitle,
            'quiz_size' => $this->quiz_size,
            'questions' => $this->questions,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('quizTitle')
                ->label('Quiz Title')
                ->required(),

            Forms\Components\TextInput::make('quiz_size')
                ->label('Quiz Size')
                ->numeric()
                ->default(0),

            Forms\Components\Repeater::make('questions')
                ->label('Questions')
                ->schema([
                    Forms\Components\TextInput::make('question_text')
                        ->label('Question')
                        ->required(),

                    Forms\Components\Repeater::make('options')
                        ->label('Options')
                        ->schema([
                            Forms\Components\TextInput::make('option_text')
                                ->label('Option Text')
                                ->required(),

                            Forms\Components\Toggle::make('is_correct')
                                ->label('Correct Answer')
                                ->default(false),
                        ])
                        ->minItems(2)
                        ->columns(1)
                        ->required(),
                ])
                ->minItems(1)
                ->columns(1)
                ->required(),
        ];
    }

    public function submit(): void
    {
        $user = Auth::guard('member')->user();

        if (!$user) {
            Notification::make()
                ->title('User not authenticated.')
                ->danger()
                ->send();
            return;
        }

        $state = $this->form->getState();

        $quiz = MyQuizzes::create([
            'title' => $state['quizTitle'],
            'user_id' => $user->id,
            'link_token' => Str::uuid(),
            'quiz_size' => count($state['questions']),
        ]);

        foreach ($state['questions'] as $questionData) {
            $question = $quiz->questions()->create([
                'question_text' => $questionData['question_text'],
            ]);

            foreach ($questionData['options'] as $optionData) {
                $question->options()->create([
                    'option_text' => $optionData['option_text'],
                    'is_correct' => $optionData['is_correct'] ?? false,
                ]);
            }
        }

        Notification::make()
            ->title('Quiz created successfully!')
            ->success()
            ->send();

        $this->quizTitle = null;
        $this->quiz_size = 0;
        $this->questions = [
            [
                'question_text' => '',
                'options' => [
                    ['option_text' => '', 'is_correct' => false],
                    ['option_text' => '', 'is_correct' => false],
                ],
            ],
        ];

        $this->form->fill([
            'quizTitle' => $this->quizTitle,
            'quiz_size' => $this->quiz_size,
            'questions' => $this->questions,
        ]);
    }

    protected function getFormModel(): string
    {
        return MyQuizzes::class;
    }
}

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
    protected static ?string $navigationLabel = 'Create My Quiz';
    protected static ?string $slug = 'create-my-quiz';
    protected static ?int $navigationSort = 2;

    public ?string $quizTitle = null;
    public ?string $description = null;
    public array $questions = [];

    public function mount(): void
    {
        if (empty($this->questions)) {
            $this->questions = [
                [
                    'question_text' => '',
                    'options' => [
                        ['option_text' => '', 'is_correct' => false],
                        ['option_text' => '', 'is_correct' => false],
                        ['option_text' => '', 'is_correct' => false],
                        ['option_text' => '', 'is_correct' => false],
                    ],
                ],
            ];
        }

        $this->form->fill([
            'quizTitle' => $this->quizTitle,
            'description' => $this->description,
            'questions' => $this->questions,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Quiz Information')
                ->schema([
                    Forms\Components\TextInput::make('quizTitle')
                        ->label('Quiz Title')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Textarea::make('description')
                        ->label('Description (Optional)')
                        ->rows(3)
                        ->maxLength(500),
                ])
                ->columns(1),

            Forms\Components\Section::make('Questions')
                ->schema([
                    Forms\Components\Repeater::make('questions')
                        ->label('')
                        ->schema([
                            Forms\Components\Textarea::make('question_text')
                                ->label('Question')
                                ->required()
                                ->rows(2)
                                ->columnSpanFull(),

                            Forms\Components\Repeater::make('options')
                                ->label('Answer Options')
                                ->schema([
                                    Forms\Components\Grid::make(12)
                                        ->schema([
                                            Forms\Components\TextInput::make('option_text')
                                                ->label('Option')
                                                ->required()
                                                ->columnSpan(10),

                                            Forms\Components\Checkbox::make('is_correct')
                                                ->label('Correct')
                                                ->columnSpan(2),
                                        ]),
                                ])
                                ->minItems(2)
                                ->maxItems(6)
                                ->defaultItems(4)
                                ->columnSpanFull()
                                ->addActionLabel('Add Option')
                                ->reorderableWithButtons()
                                ->collapsible(),
                        ])
                        ->minItems(1)
                        ->defaultItems(1)
                        ->columnSpanFull()
                        ->addActionLabel('Add Question')
                        ->reorderableWithButtons()
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['question_text'] ?? 'New Question'),
                ]),
        ];
    }

    public function submit(): void
    {
        $user = Auth::guard('member')->user();
        if (!$user) {
            Notification::make()
                ->title('Authentication Error')
                ->body('You must be logged in to create a quiz.')
                ->danger()
                ->send();
            return;
        }

        $state = $this->form->getState();

        // Validate that each question has at least one correct answer
        foreach ($state['questions'] as $index => $questionData) {
            $hasCorrectAnswer = false;
            foreach ($questionData['options'] as $option) {
                if ($option['is_correct'] ?? false) {
                    $hasCorrectAnswer = true;
                    break;
                }
            }
            
            if (!$hasCorrectAnswer) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('Question #' . ($index + 1) . ' must have at least one correct answer.')
                    ->danger()
                    ->send();
                return;
            }
        }

        try {
            $quiz = MyQuizzes::create([
                'title' => $state['quizTitle'],
                'description' => $state['description'] ?? null,
                'questions' => $state['questions'],
                'user_id' => $user->id,
                'public' => true,
            ]);

            Notification::make()
                ->title('Quiz Created Successfully!')
                ->body('Your quiz "' . $quiz->title . '" has been created with ' . count($state['questions']) . ' question(s).')
                ->success()
                ->send();

            // Reset form
            $this->quizTitle = null;
            $this->description = null;
            $this->questions = [
                [
                    'question_text' => '',
                    'options' => [
                        ['option_text' => '', 'is_correct' => false],
                        ['option_text' => '', 'is_correct' => false],
                        ['option_text' => '', 'is_correct' => false],
                        ['option_text' => '', 'is_correct' => false],
                    ],
                ],
            ];

            $this->form->fill([
                'quizTitle' => $this->quizTitle,
                'description' => $this->description,
                'questions' => $this->questions,
            ]);

            // Redirect to my quizzes page
            redirect()->route('filament.member.pages.my-quizzes');
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error Creating Quiz')
                ->body('An error occurred: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function getFormModel(): string
    {
        return MyQuizzes::class;
    }
}

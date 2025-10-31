<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\MyQuizzes;
use App\Models\Question;
use App\Models\Option;

class CreateMyQuiz extends Page implements HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $view = 'filament.member.pages.create-my-quiz';
    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?string $navigationLabel = 'Create Quiz';
    protected static ?string $slug = 'create-my-quiz';

    // Form-bound properties
    public ?string $quizTitle = null;

    public ?int $quiz_size = 0;
    public array $questions = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->label('Quiz Title')
                ->required(),

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
        /** @var \App\Models\User $user */
        $user = Auth::guard('member')->user();

        // Create the quiz
        $quiz = MyQuizzes::create([
            'title' => $this->form->getState()['title'],
            'user_id' => $user->id,
            'link_token' => Str::uuid(),
            'quiz_size' => count($this->form->getState()['questions']),
        ]);

        // Create questions and options
        foreach ($this->form->getState()['questions'] as $questionData) {
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

        // Reset form
        $this->form->fill();
    }

    protected function getFormModel(): string
    {
        return MyQuizzes::class;
    }
}

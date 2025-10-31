<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\MyQuizzes;

class CreateMyQuiz extends Page implements HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $view = 'filament.member.pages.create-my-quiz';
    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?string $navigationLabel = 'Create Quiz';
    protected static ?string $slug = 'create-my-quiz';

    // === Public properties for form binding ===
    public ?string $title = null;
    public ?int $quiz_size = 0;

    public function mount(): void
    {
        $this->form->fill(); // Fill form with default values
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->label('Quiz Title')
                ->required(),

            Forms\Components\TextInput::make('quiz_size')
                ->label('Quiz Size')
                ->numeric()
                ->default(0),
        ];
    }

    public function submit(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('member')->user();

        // get the first linked section and certification
        $sectionId = $user->sections()->pluck('id')->first();
        $certificationId = $user->certifications()->pluck('id')->first();

        if (!$sectionId || !$certificationId) {
            Notification::make()
                ->title('No linked section or certification found.')
                ->danger()
                ->send();
            return;
        }

        MyQuizzes::create([
            'title' => $this->title,
            'user_id' => $user->id,
            'link_token' => Str::uuid(),
            'section_id' => $sectionId,
            'certification_id' => $certificationId,
            'quiz_size' => $this->quiz_size ?? 0,
        ]);

        Notification::make()
            ->title('Quiz created successfully!')
            ->success()
            ->send();

        // Reset form
        $this->title = null;
        $this->quiz_size = 0;
        $this->form->fill();
    }

    protected function getFormModel(): string
    {
        return MyQuizzes::class;
    }
}

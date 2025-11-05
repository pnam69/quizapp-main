<?php

namespace App\Filament\Member\Pages;

use App\Models\AssessmentAttempt;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class MyResults extends Page
{
    protected static string $view = 'filament.member.pages.my-results';

    public static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return __('messages.my_results');
    }

    public function getTitle(): string
    {
        return __('messages.my_results');
    }

    public $assessmentAttempts;
    public $selectedAttempt = null;

    public function mount(): void
    {
        $this->assessmentAttempts = AssessmentAttempt::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->with([
                'assessment.questions.options',
                'attemptAnswers.question.options'
            ])
            ->orderBy('submitted_at', 'desc')
            ->get();
    }

    public function viewAttempt($attemptId): void
    {
        $this->selectedAttempt = AssessmentAttempt::with([
            'assessment.questions.options',
            'attemptAnswers.question.options'
        ])->find($attemptId);
    }

    public function backToList(): void
    {
        $this->selectedAttempt = null;
    }
}

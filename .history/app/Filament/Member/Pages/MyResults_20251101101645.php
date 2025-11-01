<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class MyResults extends Page
{
    protected static string $view = 'filament.member.pages.my-results';

    public static ?string $navigationIcon = 'heroicon-o-document-text';
    public static ?string $navigationLabel = 'My Results';

    public $completedQuizzes;

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('member')->user();

        $this->completedQuizzes = $user->quizzes()
            ->with(['section', 'certification'])
            ->where('completed', 1)
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}

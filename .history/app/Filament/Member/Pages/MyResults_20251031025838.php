<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\QuizHeader;

class MyResults extends Page
{
    protected static string $view = 'filament.member.pages.my-results';
    public static ?string $navigationIcon = 'heroicon-o-document-text';
    public static ?string $navigationLabel = 'My Results';

    public $completedQuizzes;

    public function mount(): void
    {
        $user = Auth::guard('member')->user();
        $this->completedQuizzes = QuizHeader::where('user_id', $user->id)
            ->where('completed', 1)
            ->get();
    }
}

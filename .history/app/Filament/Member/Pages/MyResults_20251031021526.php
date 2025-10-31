<?php

namespace App\Filament\Member\Pages;

use App\Models\QuizHeader;
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
        $user = Auth::guard('member')->user();

        $this->completedQuizzes = QuizHeader::whereHas('answers', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();
    }
}

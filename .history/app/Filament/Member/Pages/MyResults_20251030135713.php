<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use App\Models\QuizHeader;
use Illuminate\Support\Facades\Auth;

class MyResults extends Page
{
    protected static string $view = 'filament.member.pages.my-results';

    public $completedQuizzes;

    public function mount()
    {
        $user = Auth::guard('member')->user();

        $this->completedQuizzes = QuizHeader::where('user_id', $user->id)
            ->where('completed', 1)
            ->get();
    }
}

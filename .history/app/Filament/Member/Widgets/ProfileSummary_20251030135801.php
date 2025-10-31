<?php

namespace App\Filament\Member\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class ProfileSummary extends Widget
{
    protected static string $view = 'filament.member.widgets.profile-summary';

    public $sections;
    public $certifications;
    public $completedQuizzes;
    public $totalQuizzes;

    public function mount()
    {
        $user = Auth::guard('member')->user();
        $this->sections = $user->sections()->pluck('name');
        $this->certifications = $user->certifications()->pluck('name');

        $quizzes = $user->quizzes ?? collect();
        $this->completedQuizzes = $quizzes->where('completed', 1)->count();
        $this->totalQuizzes = $quizzes->count();
    }
}

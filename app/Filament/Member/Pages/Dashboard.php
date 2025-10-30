<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use App\Models\QuizHeader;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static string $view = 'filament.member.pages.dashboard';

    public $totalQuizzes;
    public $completedQuizzes;
    public $recentResults;
    public $nextQuiz;

    public function mount()
    {
        $user = Auth::user();

        $sectionIds = $user->sections()->pluck('sections.id');
        $certificationIds = $user->certifications()->pluck('certifications.id');

        $quizzes = QuizHeader::whereIn('section_id', $sectionIds)
            ->orWhereIn('certification_id', $certificationIds)
            ->get();

        $this->totalQuizzes = $quizzes->count();
        $this->completedQuizzes = $quizzes->where('completed', 1)->count();

        $this->recentResults = $quizzes
            ->where('completed', 1)
            ->sortByDesc('updated_at')
            ->take(3);

        $this->nextQuiz = $quizzes
            ->where('completed', 0)
            ->sortBy('created_at')
            ->first();
    }
}

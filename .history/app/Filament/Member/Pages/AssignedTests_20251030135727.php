<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use App\Models\QuizHeader;
use Illuminate\Support\Facades\Auth;

class AssignedTests extends Page
{
    protected static string $view = 'filament.member.pages.assigned-tests';

    public $assignedQuizzes;

    public function mount()
    {
        $user = Auth::guard('member')->user();

        $sectionIds = $user->sections()->pluck('sections.id');
        $certificationIds = $user->certifications()->pluck('certifications.id');

        $this->assignedQuizzes = QuizHeader::whereIn('section_id', $sectionIds)
            ->orWhereIn('certification_id', $certificationIds)
            ->where('completed', 0)
            ->get();
    }
}

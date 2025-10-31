<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\QuizHeader;

class AssignedTests extends Page
{
    protected static string $view = 'filament.member.pages.assigned-tests';

    public static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    public static ?string $navigationLabel = 'Assigned Tests';

    public $assignedQuizzes;

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('member')->user();

        $sectionIds = $user->sections()->pluck('sections.id');
        $certificationIds = $user->certifications()->pluck('certifications.id');

        $this->assignedQuizzes = QuizHeader::whereIn('section_id', $sectionIds)
            ->orWhereIn('certification_id', $certificationIds)
            ->where('completed', 0)
            ->get();
    }
}

<?php

namespace App\Filament\Member\Widgets;

use App\Models\Homework;
use App\Models\HomeworkSubmission;
use App\Models\QuizHeader;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class QuickActionsWidget extends Widget
{
    protected static string $view = 'filament.member.widgets.quick-actions';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $user = Auth::guard('member')->user();

        // Get pending homework
        $classroomIds = $user->classrooms->pluck('id');
        $pendingHomework = Homework::where('is_published', true)
            ->where('due_date', '>=', now())
            ->where(function ($query) use ($classroomIds) {
                $query->whereIn('classroom_id', $classroomIds)
                    ->orWhereNull('classroom_id');
            })
            ->whereDoesntHave('submissions', function ($query) use ($user) {
                $query->where('student_id', $user->id);
            })
            ->orderBy('due_date')
            ->take(3)
            ->get();

        // Get next quiz
        $sectionIds = $user->sections()->pluck('sections.id');
        $certificationIds = $user->certifications()->pluck('certifications.id');

        $nextQuiz = QuizHeader::whereIn('section_id', $sectionIds)
            ->orWhereIn('certification_id', $certificationIds)
            ->where('completed', 0)
            ->orderBy('created_at')
            ->first();

        // Get overdue homework
        $overdueHomework = Homework::where('is_published', true)
            ->where('due_date', '<', now())
            ->where('allow_late_submission', true)
            ->where(function ($query) use ($classroomIds) {
                $query->whereIn('classroom_id', $classroomIds)
                    ->orWhereNull('classroom_id');
            })
            ->whereDoesntHave('submissions', function ($query) use ($user) {
                $query->where('student_id', $user->id);
            })
            ->count();

        return [
            'pendingHomework' => $pendingHomework,
            'nextQuiz' => $nextQuiz,
            'overdueHomework' => $overdueHomework,
        ];
    }
}

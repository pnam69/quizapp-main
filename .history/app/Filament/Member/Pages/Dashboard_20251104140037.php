<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use App\Models\AssessmentAttempt;
use App\Models\Assessment;
use App\Models\Homework;
use App\Models\HomeworkSubmission;
use App\Models\Hub;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.member.pages.dashboard';
    protected static ?int $navigationSort = 1;

    public $totalAssessments = 0;
    public $completedAssessments = 0;
    public $recentResults;
    public $nextAssessment;
    public $pendingHomework = 0;
    public $gradedHomework;
    public $averageScore = 0;
    public $recentMaterials;

    public function mount(): void
    {
        $user = Auth::user();
        $sectionIds = $user->sections->pluck('id');
        $classroomIds = $user->classrooms->pluck('id');

        // Get all assessments available to the user
        $assessments = Assessment::where(function ($query) use ($sectionIds, $classroomIds) {
            $query->whereIn('section_id', $sectionIds)
                ->orWhereIn('classroom_id', $classroomIds);
        })->where('is_published', true)
            ->where('is_active', true)
            ->get();

        // Get user's assessment attempts
        $attempts = AssessmentAttempt::where('user_id', $user->id)
            ->whereIn('assessment_id', $assessments->pluck('id'))
            ->get();

        // Statistics
        $this->totalAssessments = $assessments->count();
        $this->completedAssessments = $attempts->where('status', 'completed')->count();

        // Recent Results - Last 3 completed attempts
        $this->recentResults = AssessmentAttempt::where('user_id', $user->id)
            ->where('status', 'completed')
            ->with('assessment')
            ->orderBy('submitted_at', 'desc')
            ->take(3)
            ->get();

        // Next Assessment - First incomplete or not attempted
        $completedAssessmentIds = $attempts->where('status', 'completed')->pluck('assessment_id');
        $this->nextAssessment = $assessments
            ->whereNotIn('id', $completedAssessmentIds)
            ->sortBy('created_at')
            ->first();

        // Homework statistics - count pending/awaiting grading homework
        $this->pendingHomework = Homework::where(function ($query) use ($sectionIds, $classroomIds) {
            $query->whereIn('section_id', $sectionIds)
                ->orWhereIn('classroom_id', $classroomIds);
        })
            ->where(function ($query) {
                $query->whereNull('due_date')
                    ->orWhere('due_date', '>=', now());
            })
            ->whereDoesntHave('submissions', function ($query) use ($user) {
                $query->where('student_id', $user->id)
                    ->whereIn('status', ['submitted', 'graded']);
            })
            ->count();

        // Recent graded homework
        $this->gradedHomework = HomeworkSubmission::where('student_id', $user->id)
            ->whereIn('status', ['submitted', 'graded'])
            ->with('homework')
            ->orderBy('submitted_at', 'desc')
            ->take(3)
            ->get();

        // Calculate average score from assessment attempts
        $completedAttempts = $attempts->where('status', 'completed');
        if ($completedAttempts->count() > 0) {
            $this->averageScore = $completedAttempts->map(function ($attempt) {
                return $attempt->percentage ?? 0;
            })->average();
        } else {
            $this->averageScore = 0;
        }

        // Recent study materials
        $this->recentMaterials = Hub::whereIn('section_id', $sectionIds)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }
}

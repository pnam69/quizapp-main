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

    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Quiz Statistics
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

        // Homework Statistics
        $classroomIds = $user->classrooms->pluck('id');

        $homeworkQuery = Homework::where('is_published', true)
            ->where(function ($query) use ($classroomIds) {
                $query->whereIn('classroom_id', $classroomIds)
                    ->orWhereNull('classroom_id');
            });

        $allHomework = $homeworkQuery->get();

        $this->pendingHomework = $allHomework->filter(function ($homework) use ($user) {
            $submission = HomeworkSubmission::where('homework_id', $homework->id)
                ->where('student_id', $user->id)
                ->first();
            return !$submission || $submission->status === 'not_submitted';
        })->count();

        $this->gradedHomework = HomeworkSubmission::where('student_id', $user->id)
            ->where('status', 'graded')
            ->latest()
            ->take(3)
            ->get();

        // Calculate average score
        $gradedSubmissions = HomeworkSubmission::where('student_id', $user->id)
            ->where('status', 'graded')
            ->whereNotNull('score')
            ->get();

        $this->averageScore = $gradedSubmissions->count() > 0
            ? $gradedSubmissions->avg(function ($submission) {
                return ($submission->score / $submission->homework->max_points) * 100;
            })
            : 0;

        // Recent study materials
        $this->recentMaterials = Hub::latest()
            ->take(5)
            ->get();
    }
}

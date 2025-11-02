<?php

namespace App\Filament\Widgets;

use App\Models\Homework;
use App\Models\HomeworkSubmission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HomeworkStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalHomework = Homework::where('is_published', true)->count();
        $activeHomework = Homework::where('is_published', true)
            ->where('due_date', '>', now())
            ->count();
        $overdueHomework = Homework::where('is_published', true)
            ->where('due_date', '<', now())
            ->count();

        $totalSubmissions = HomeworkSubmission::whereHas('homework', function($query) {
            $query->where('is_published', true);
        })->count();

        $pendingGrading = HomeworkSubmission::whereIn('status', ['submitted', 'late'])
            ->count();

        $averageSubmissionRate = Homework::where('is_published', true)
            ->get()
            ->avg(function($homework) {
                return $homework->submissionRate();
            });

        return [
            Stat::make('Total Assignments', $totalHomework)
                ->description('Published homework assignments')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary')
                ->chart([7, 12, 15, 18, 20, 22, $totalHomework]),

            Stat::make('Active Assignments', $activeHomework)
                ->description('Currently due')
                ->descriptionIcon('heroicon-o-clock')
                ->color('success')
                ->chart([5, 8, 10, 12, 14, 16, $activeHomework]),

            Stat::make('Overdue Assignments', $overdueHomework)
                ->description('Past deadline')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('danger')
                ->chart([2, 3, 4, 5, 6, 7, $overdueHomework]),

            Stat::make('Pending Grading', $pendingGrading)
                ->description('Submissions awaiting grades')
                ->descriptionIcon('heroicon-o-pencil-square')
                ->color('warning')
                ->chart([3, 5, 8, 10, 12, 15, $pendingGrading]),

            Stat::make('Submission Rate', number_format($averageSubmissionRate, 1) . '%')
                ->description('Average across all assignments')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color($averageSubmissionRate >= 70 ? 'success' : 'warning'),
        ];
    }
}

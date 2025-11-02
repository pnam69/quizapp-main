<?php

namespace App\Filament\Widgets;

use App\Models\HomeworkSubmission;
use App\Models\QuizHeader;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class StudentActivityChart extends ChartWidget
{
    protected static ?string $heading = 'Student Activity (Last 7 Days)';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $days = collect(range(6, 0))->map(function ($daysAgo) {
            return Carbon::now()->subDays($daysAgo)->format('M d');
        });

        $homeworkSubmissions = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::now()->subDays($daysAgo)->startOfDay();
            return HomeworkSubmission::whereDate('submitted_at', $date)->count();
        });

        $quizAttempts = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::now()->subDays($daysAgo)->startOfDay();
            return QuizHeader::whereDate('created_at', $date)
                ->where('completed', true)
                ->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Homework Submissions',
                    'data' => $homeworkSubmissions->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
                [
                    'label' => 'Quiz Attempts',
                    'data' => $quizAttempts->toArray(),
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'borderColor' => 'rgb(16, 185, 129)',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $days->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }
}

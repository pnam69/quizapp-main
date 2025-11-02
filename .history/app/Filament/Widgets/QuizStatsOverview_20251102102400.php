<?php

namespace App\Filament\Widgets;

use App\Models\Test;
use App\Models\QuizHeader;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class QuizStatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalTests = Test::where('is_active', true)->count();
        
        $totalAttempts = QuizHeader::whereNotNull('test_id')
            ->where('completed', true)
            ->count();

        $averageScore = QuizHeader::whereNotNull('test_id')
            ->where('completed', true)
            ->avg('score') ?? 0;

        $passRate = QuizHeader::whereNotNull('test_id')
            ->where('completed', true)
            ->where('score', '>=', 70)
            ->count();
        
        $totalCompleted = QuizHeader::whereNotNull('test_id')
            ->where('completed', true)
            ->count();

        $passPercentage = $totalCompleted > 0 ? ($passRate / $totalCompleted) * 100 : 0;

        $recentAttempts = QuizHeader::whereNotNull('test_id')
            ->where('completed', true)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        return [
            Stat::make('Active Tests', $totalTests)
                ->description('Available for students')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('primary'),

            Stat::make('Total Attempts', $totalAttempts)
                ->description($recentAttempts . ' in last 7 days')
                ->descriptionIcon('heroicon-o-users')
                ->color('info')
                ->chart([45, 52, 48, 65, 72, 68, $recentAttempts]),

            Stat::make('Average Score', number_format($averageScore, 1) . '%')
                ->description('Across all completed tests')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color($averageScore >= 70 ? 'success' : 'warning'),

            Stat::make('Pass Rate', number_format($passPercentage, 1) . '%')
                ->description('Students scoring 70% or higher')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color($passPercentage >= 70 ? 'success' : 'danger'),
        ];
    }
}

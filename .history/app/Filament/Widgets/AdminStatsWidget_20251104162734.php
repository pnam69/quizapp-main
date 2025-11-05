<?php

namespace App\Filament\Widgets;

use App\Models\QuizHeader;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class AdminStatsWidget extends ChartWidget
{
    use HasWidgetShield;

    protected static ?string $heading = 'User Growth';

    protected static ?int $sort = 5;

    protected function getData(): array
    {
        $data1 = Trend::model(User::class)
            ->between(
                start: now()->subDays(15),
                end: now()->addDays(1),
            )
            ->perDay()
            ->count();

        $data2 = Trend::model(QuizHeader::class)
            ->between(
                start: now()->subDays(15),
                end: now()->addDays(1),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $data1->map(fn(TrendValue $value) => $value->aggregate),
                    'fill' => 'start',
                    'type' => 'line',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => '#3B82F6',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Quizzes',
                    'data' => $data2->map(fn(TrendValue $value) => $value->aggregate),
                    'fill' => 'start',
                    'type' => 'line',
                    'backgroundColor' => 'rgba(168, 85, 247, 0.1)',
                    'borderColor' => '#A855F7',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data1->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

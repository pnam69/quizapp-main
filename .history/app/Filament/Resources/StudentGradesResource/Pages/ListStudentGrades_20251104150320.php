<?php

namespace App\Filament\Resources\StudentGradesResource\Pages;

use App\Filament\Resources\StudentGradesResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListStudentGrades extends ListRecords
{
    protected static string $resource = StudentGradesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Export button moved to table header actions
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Grades')
                ->icon('heroicon-o-clipboard-document-list'),

            'excellent' => Tab::make('Passed (≥70%)')
                ->icon('heroicon-o-check-badge')
                ->badge(fn() => $this->getModel()::query()->where('status', 'completed')->where('percentage', '>=', 70)->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('percentage', '>=', 70)),

            'needs_improvement' => Tab::make('Needs Improvement (50-70%)')
                ->icon('heroicon-o-exclamation-triangle')
                ->badge(fn() => $this->getModel()::query()->where('status', 'completed')->where('percentage', '>=', 50)->where('percentage', '<', 70)->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('percentage', '>=', 50)->where('percentage', '<', 70)),

            'failed' => Tab::make('Failed (<50%)')
                ->icon('heroicon-o-x-circle')
                ->badge(fn() => $this->getModel()::query()->where('status', 'completed')->where('percentage', '<', 50)->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('percentage', '<', 50)),
        ];
    }
}

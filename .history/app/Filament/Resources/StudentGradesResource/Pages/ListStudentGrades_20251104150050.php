<?php

namespace App\Filament\Resources\StudentGradesResource\Pages;

use App\Filament\Resources\StudentGradesResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListStudentGrades extends ListRecords
{
    protected static string $resource = StudentGradesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Export Grades')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn () => 'student-grades-' . date('Y-m-d-His'))
                        ->withColumns([
                            Column::make('user.name')->heading('Student Name'),
                            Column::make('user.email')->heading('Email'),
                            Column::make('assessment.title')->heading('Assessment'),
                            Column::make('percentage')->heading('Score (%)')->formatStateUsing(fn ($state) => round($state, 2) . '%'),
                            Column::make('grade_status')->heading('Grade Status')->formatStateUsing(function ($record) {
                                if ($record->percentage >= 70) return 'Passed';
                                if ($record->percentage >= 50) return 'Needs Improvement';
                                return 'Failed';
                            }),
                            Column::make('correct_answers')->heading('Correct Answers')->formatStateUsing(fn ($record) => $record->attemptAnswers->where('is_correct', true)->count()),
                            Column::make('total_questions')->heading('Total Questions')->formatStateUsing(fn ($record) => $record->attemptAnswers->count()),
                            Column::make('time_spent')->heading('Time Spent (min)')->formatStateUsing(function ($record) {
                                if ($record->started_at && $record->submitted_at) {
                                    return $record->started_at->diffInMinutes($record->submitted_at);
                                }
                                return 'N/A';
                            }),
                            Column::make('user.classrooms')->heading('Classroom')->formatStateUsing(fn ($record) => $record->user->classrooms->pluck('name')->join(', ') ?: 'N/A'),
                            Column::make('user.sections')->heading('Faculty')->formatStateUsing(fn ($record) => $record->user->sections->pluck('name')->join(', ') ?: 'N/A'),
                            Column::make('user.certifications')->heading('Department')->formatStateUsing(fn ($record) => $record->user->certifications->pluck('name')->join(', ') ?: 'N/A'),
                            Column::make('submitted_at')->heading('Submission Date')->formatStateUsing(fn ($state) => $state?->format('M d, Y h:i A')),
                            Column::make('status')->heading('Status'),
                        ])
                ]),
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

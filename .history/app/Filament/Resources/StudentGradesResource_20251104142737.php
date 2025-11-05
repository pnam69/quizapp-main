<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentGradesResource\Pages;
use App\Models\AssessmentAttempt;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;

class StudentGradesResource extends Resource
{
    protected static ?string $model = AssessmentAttempt::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Student Grades';

    protected static ?string $modelLabel = 'Student Grade';

    protected static ?string $pluralModelLabel = 'Student Grades';

    protected static ?string $navigationGroup = 'Academic Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Read-only form - grades shouldn't be edited
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                // If not admin, filter by teacher's assigned classrooms
                if (!$user->is_admin) {
                    $classroomIds = $user->classrooms->pluck('id');
                    $query->whereHas('user.classrooms', function ($q) use ($classroomIds) {
                        $q->whereIn('classrooms.id', $classroomIds);
                    });
                }

                return $query->where('status', 'completed')
                    ->with(['user', 'assessment', 'user.classrooms', 'user.sections', 'user.certifications']);
            })
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.sections.name')
                    ->label('Faculty')
                    ->badge()
                    ->color('info')
                    ->separator(',')
                    ->limit(30),

                Tables\Columns\TextColumn::make('user.certifications.name')
                    ->label('Department')
                    ->badge()
                    ->color('warning')
                    ->separator(',')
                    ->limit(30),

                Tables\Columns\TextColumn::make('user.classrooms.name')
                    ->label('Classroom')
                    ->badge()
                    ->separator(',')
                    ->limit(20),

                Tables\Columns\TextColumn::make('assessment.title')
                    ->label('Assessment')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('percentage')
                    ->label('Score')
                    ->sortable()
                    ->formatStateUsing(
                        fn($state) => round($state, 1) . '%'
                    )
                    ->badge()
                    ->color(
                        fn($state) =>
                        $state >= 80
                            ? 'success'
                            : ($state >= 60
                                ? 'warning'
                                : 'danger')
                    ),

                Tables\Columns\IconColumn::make('passed')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Completed At')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('time_taken')
                    ->label('Time Taken')
                    ->formatStateUsing(function ($record) {
                        if (!$record->started_at || !$record->submitted_at) {
                            return 'N/A';
                        }
                        $minutes = $record->started_at->diffInMinutes($record->submitted_at);
                        return $minutes . ' min';
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->groups([
                Tables\Grouping\Group::make('user.sections.name')
                    ->label('Faculty')
                    ->collapsible(),

                Tables\Grouping\Group::make('user.certifications.name')
                    ->label('Department')
                    ->collapsible(),

                Tables\Grouping\Group::make('assessment.title')
                    ->label('Assessment')
                    ->collapsible(),
            ])
            ->groups([
                Tables\Grouping\Group::make('user.sections.name')
                    ->label('Faculty')
                    ->collapsible(),

                Tables\Grouping\Group::make('user.certifications.name')
                    ->label('Department')
                    ->collapsible(),

                Tables\Grouping\Group::make('assessment.title')
                    ->label('Assessment')
                    ->collapsible(),
            ])
            ->filters([
                SelectFilter::make('classroom')
                    ->relationship('user.classrooms', 'name')
                    ->label('Classroom')
                    ->multiple()
                    ->preload(),

                SelectFilter::make('section')
                    ->relationship('user.sections', 'name')
                    ->label('Faculty')
                    ->multiple()
                    ->preload(),

                SelectFilter::make('certification')
                    ->relationship('user.certifications', 'name')
                    ->label('Department')
                    ->multiple()
                    ->preload(),

                SelectFilter::make('assessment')
                    ->relationship('assessment', 'title')
                    ->label('Assessment')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('passed')
                    ->label('Status')
                    ->options([
                        '1' => 'Passed',
                        '0' => 'Failed',
                    ]),

                Tables\Filters\Filter::make('high_scores')
                    ->label('High Scores (≥80%)')
                    ->query(fn(Builder $query) => $query->where('percentage', '>=', 80)),

                Tables\Filters\Filter::make('low_scores')
                    ->label('Low Scores (<60%)')
                    ->query(fn(Builder $query) => $query->where('percentage', '<', 60)),

                Tables\Filters\Filter::make('multiple_assessments')
                    ->label('Students with Multiple Assessments')
                    ->query(function (Builder $query) {
                        $subQuery = AssessmentAttempt::selectRaw('user_id, COUNT(*) as attempt_count')
                            ->where('status', 'completed')
                            ->groupBy('user_id')
                            ->having('attempt_count', '>', 1);

                        return $query->whereIn('user_id', $subQuery->pluck('user_id'));
                    }),

                Tables\Filters\Filter::make('recent_grades')
                    ->label('Recent Grades (Last 7 days)')
                    ->query(fn(Builder $query) => $query->where('submitted_at', '>=', now()->subDays(7))),

                Tables\Filters\Filter::make('needs_attention')
                    ->label('Needs Attention (<50%)')
                    ->query(fn(Builder $query) => $query->where('percentage', '<', 50)),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_grades')
                    ->label('Export Grades')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function () {
                        // Export functionality can be added later
                        $this->notify('success', 'Export functionality coming soon!');
                    }),

                Tables\Actions\Action::make('view_summary')
                    ->label('View Summary')
                    ->icon('heroicon-o-chart-bar')
                    ->modalHeading('Grade Summary Overview')
                    ->modalContent(function () {
                        $query = static::getModel()::query()
                            ->where('status', 'completed')
                            ->with(['user', 'assessment']);

                        $user = Auth::user();
                        if (!$user->is_admin) {
                            $classroomIds = $user->classrooms->pluck('id');
                            $query->whereHas('user.classrooms', function ($q) use ($classroomIds) {
                                $q->whereIn('classrooms.id', $classroomIds);
                            });
                        }

                        $attempts = $query->get();

                        $totalStudents = $attempts->unique('user_id')->count();
                        $totalAssessments = $attempts->unique('assessment_id')->count();
                        $averageScore = $attempts->avg('percentage');
                        $passRate = $attempts->where('passed', true)->count() / max($attempts->count(), 1) * 100;

                        return view('filament.resources.student-grades.summary-modal', [
                            'totalStudents' => $totalStudents,
                            'totalAssessments' => $totalAssessments,
                            'averageScore' => round($averageScore, 1),
                            'passRate' => round($passRate, 1),
                            'totalAttempts' => $attempts->count(),
                        ]);
                    })
                    ->modalSubmitAction(false)
                    ->slideOver(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading(fn($record) => 'Grade Details: ' . $record->user->name)
                    ->modalContent(fn($record) => view('filament.resources.student-grades.view-grade', ['record' => $record])),
            ])
            ->bulkActions([
                // No bulk actions for viewing grades
            ])
            ->defaultSort('submitted_at', 'desc')
            ->poll('30s'); // Auto-refresh every 30 seconds
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentGrades::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Grades are created through assessments
    }
}

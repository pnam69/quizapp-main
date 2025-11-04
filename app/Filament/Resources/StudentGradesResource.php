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

                Tables\Columns\TextColumn::make('assessment.title')
                    ->label('Assessment')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('user.classrooms.name')
                    ->label('Classroom')
                    ->badge()
                    ->separator(',')
                    ->limit(20),

                Tables\Columns\TextColumn::make('user.sections.name')
                    ->label('Faculty')
                    ->badge()
                    ->color('info')
                    ->separator(',')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('user.certifications.name')
                    ->label('Department')
                    ->badge()
                    ->color('warning')
                    ->separator(',')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->sortable()
                    ->formatStateUsing(
                        fn($state, $record) =>
                        $record->total_points > 0
                            ? round(($state / $record->total_points) * 100, 1) . '%'
                            : '0%'
                    )
                    ->badge()
                    ->color(
                        fn($state, $record) =>
                        $record->total_points > 0 && (($state / $record->total_points) * 100) >= 80
                            ? 'success'
                            : ($record->total_points > 0 && (($state / $record->total_points) * 100) >= 60
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
                    ->query(fn(Builder $query) => $query->whereRaw('(score / total_points) * 100 >= 80')),

                Tables\Filters\Filter::make('low_scores')
                    ->label('Low Scores (<60%)')
                    ->query(fn(Builder $query) => $query->whereRaw('(score / total_points) * 100 < 60')),
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

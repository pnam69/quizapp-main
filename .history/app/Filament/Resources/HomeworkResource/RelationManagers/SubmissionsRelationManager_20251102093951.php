<?php

namespace App\Filament\Resources\HomeworkResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Student Submission')
                    ->schema([
                        Forms\Components\Placeholder::make('student_name')
                            ->label('Student')
                            ->content(fn($record) => $record->student->name ?? 'N/A'),

                        Forms\Components\Placeholder::make('submitted_at')
                            ->label('Submitted At')
                            ->content(fn($record) => $record->submitted_at?->format('M d, Y h:i A') ?? 'Not submitted'),

                        Forms\Components\Placeholder::make('status_display')
                            ->label('Status')
                            ->content(fn($record) => ucfirst(str_replace('_', ' ', $record->status))),

                        Forms\Components\Textarea::make('submission_text')
                            ->label('Student Answer')
                            ->disabled()
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('files_display')
                            ->label('Submitted Files')
                            ->content(function ($record) {
                                if (empty($record->submitted_files)) {
                                    return 'No files submitted';
                                }
                                $files = is_array($record->submitted_files) ? $record->submitted_files : [];
                                return implode(', ', array_map(fn($file) => basename($file), $files));
                            })
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Grading')
                    ->schema([
                        Forms\Components\TextInput::make('score')
                            ->label('Score')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(fn() => $this->ownerRecord->max_points)
                            ->suffix('/ ' . ($this->ownerRecord->max_points ?? 100) . ' points')
                            ->required(),

                        Forms\Components\Textarea::make('teacher_feedback')
                            ->label('Feedback for Student')
                            ->rows(4)
                            ->placeholder('Provide constructive feedback...')
                            ->columnSpanFull(),

                        Forms\Components\Hidden::make('graded_by')
                            ->default(fn() => Auth::id()),

                        Forms\Components\Hidden::make('graded_at')
                            ->default(fn() => now()),

                        Forms\Components\Hidden::make('status')
                            ->default('graded'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('student.name')
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'not_submitted' => 'gray',
                        'submitted' => 'warning',
                        'late' => 'danger',
                        'graded' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => ucfirst(str_replace('_', ' ', $state))),

                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime('M d, Y h:i A')
                    ->placeholder('Not yet')
                    ->sortable(),

                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->formatStateUsing(fn($record) => $record->score !== null
                        ? $record->score . '/' . $record->homework->max_points
                        : 'Not graded')
                    ->color(fn($record) => $record->score !== null
                        ? ($record->score / $record->homework->max_points >= 0.7 ? 'success' : 'danger')
                        : 'gray'),

                Tables\Columns\IconColumn::make('has_files')
                    ->label('Files')
                    ->boolean()
                    ->getStateUsing(fn($record) => !empty($record->submitted_files))
                    ->trueIcon('heroicon-o-paper-clip')
                    ->falseIcon('heroicon-o-x-mark'),

                Tables\Columns\TextColumn::make('graded_at')
                    ->label('Graded')
                    ->dateTime('M d, Y')
                    ->placeholder('Not graded')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'not_submitted' => 'Not Submitted',
                        'submitted' => 'Submitted',
                        'late' => 'Late',
                        'graded' => 'Graded',
                    ]),
            ])
            ->headerActions([
                // Don't allow manual creation of submissions
            ])
            ->actions([
                Tables\Actions\Action::make('download_files')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn($record) => !empty($record->submitted_files))
                    ->url(fn($record) => Storage::url($record->submitted_files[0] ?? ''))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make()
                    ->label('Grade')
                    ->icon('heroicon-o-pencil-square')
                    ->visible(fn($record) => $record->canBeGraded()),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // No bulk actions for submissions
            ])
            ->defaultSort('submitted_at', 'desc')
            ->emptyStateHeading('No Submissions Yet')
            ->emptyStateDescription('Students haven\'t submitted their work yet.');
    }
}

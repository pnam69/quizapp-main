<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeworkSubmissionResource\Pages;
use App\Filament\Resources\HomeworkSubmissionResource\RelationManagers;
use App\Models\HomeworkSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomeworkSubmissionResource extends Resource
{
    protected static ?string $model = HomeworkSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Homework Submissions';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('homework_id')
                    ->relationship('homework', 'title')
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'name')
                    ->required()
                    ->searchable(),

                Forms\Components\Textarea::make('submission_text')
                    ->label('Submission Text')
                    ->rows(4),

                Forms\Components\FileUpload::make('submitted_files')
                    ->label('Submitted Files')
                    ->multiple()
                    ->disk('public')
                    ->directory('homework_submissions')
                    ->preserveFilenames()
                    ->maxSize(10240)
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'image/jpeg',
                        'image/png',
                        'text/plain',
                    ]),

                Forms\Components\TextInput::make('score')
                    ->label('Score')
                    ->numeric()
                    ->minValue(0),

                Forms\Components\Textarea::make('teacher_feedback')
                    ->label('Teacher Feedback')
                    ->rows(3),

                Forms\Components\Select::make('status')
                    ->options([
                        'not_submitted' => 'Not Submitted',
                        'submitted' => 'Submitted',
                        'graded' => 'Graded',
                        'late' => 'Late',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('homework.title')
                    ->label('Assignment')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('student.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'not_submitted' => 'gray',
                        'submitted' => 'warning',
                        'graded' => 'success',
                        'late' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->suffix('/' . Tables\Columns\TextColumn::make('homework.max_points')->getState())
                    ->placeholder('Not graded'),

                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('homework.due_date')
                    ->label('Due Date')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('homework.teacher.name')
                    ->label('Teacher')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'not_submitted' => 'Not Submitted',
                        'submitted' => 'Submitted',
                        'graded' => 'Graded',
                        'late' => 'Late',
                    ]),

                Tables\Filters\SelectFilter::make('homework')
                    ->relationship('homework', 'title'),

                Tables\Filters\SelectFilter::make('student')
                    ->relationship('student', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('submitted_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomeworkSubmissions::route('/'),
            'create' => Pages\CreateHomeworkSubmission::route('/create'),
            'edit' => Pages\EditHomeworkSubmission::route('/{record}/edit'),
        ];
    }
}

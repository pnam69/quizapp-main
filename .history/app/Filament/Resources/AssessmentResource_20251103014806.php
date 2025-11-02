<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssessmentResource\Pages;
use App\Filament\Resources\AssessmentResource\RelationManagers;
use App\Models\Assessment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssessmentResource extends Resource
{
    protected static ?string $model = Assessment::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Assessments';

    protected static ?string $navigationGroup = 'Academic';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),

                                Forms\Components\Textarea::make('description')
                                    ->rows(3)
                                    ->columnSpan(2),

                                Forms\Components\Select::make('type')
                                    ->options([
                                        'test' => 'Test',
                                        'quiz' => 'Quiz',
                                        'practice' => 'Practice',
                                        'exam' => 'Exam',
                                    ])
                                    ->required()
                                    ->default('test'),

                                Forms\Components\Select::make('difficulty')
                                    ->options([
                                        'easy' => 'Easy',
                                        'medium' => 'Medium',
                                        'hard' => 'Hard',
                                    ])
                                    ->default('medium'),

                                Forms\Components\TextInput::make('category')
                                    ->maxLength(100),

                                Forms\Components\TagsInput::make('tags')
                                    ->placeholder('Add tags'),
                            ]),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Assignment')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('teacher_id')
                                    ->relationship('teacher', 'name')
                                    ->label('Teacher/Instructor')
                                    ->searchable()
                                    ->default(fn() => auth()->id()),

                                Forms\Components\Select::make('classroom_id')
                                    ->relationship('classroom', 'name')
                                    ->label('Class/Group')
                                    ->searchable(),

                                Forms\Components\Select::make('section_id')
                                    ->relationship('section', 'name')
                                    ->label('Faculty')
                                    ->searchable(),

                                Forms\Components\Select::make('certification_id')
                                    ->relationship('certification', 'name')
                                    ->label('Department')
                                    ->searchable(),
                            ]),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('time_limit')
                                    ->numeric()
                                    ->suffix('minutes')
                                    ->helperText('Leave empty for no time limit'),

                                Forms\Components\TextInput::make('passing_score')
                                    ->numeric()
                                    ->default(70)
                                    ->suffix('%')
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->required(),

                                Forms\Components\TextInput::make('attempts_allowed')
                                    ->numeric()
                                    ->default(1)
                                    ->helperText('-1 for unlimited attempts')
                                    ->required(),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Toggle::make('shuffle_questions')
                                    ->label('Shuffle Questions')
                                    ->helperText('Randomize question order for each student'),

                                Forms\Components\Toggle::make('shuffle_options')
                                    ->label('Shuffle Options')
                                    ->helperText('Randomize answer options'),

                                Forms\Components\Toggle::make('show_correct_answers')
                                    ->label('Show Correct Answers')
                                    ->default(true)
                                    ->helperText('Show correct answers after submission'),
                            ]),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Scheduling')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('available_from')
                                    ->label('Available From')
                                    ->helperText('Leave empty for immediate availability'),

                                Forms\Components\DateTimePicker::make('available_until')
                                    ->label('Available Until')
                                    ->helperText('Leave empty for no expiration'),
                            ]),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Questions')
                    ->schema([
                        Forms\Components\Repeater::make('questions')
                            ->relationship('questions')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\Textarea::make('question_text')
                                            ->label('Question')
                                            ->required()
                                            ->rows(2)
                                            ->columnSpan(2),

                                        Forms\Components\Select::make('question_type')
                                            ->label('Type')
                                            ->options([
                                                'multiple_choice' => 'Multiple Choice',
                                                'true_false' => 'True/False',
                                                'multiple_answer' => 'Multiple Answers',
                                                'fill_blank' => 'Fill in the Blank',
                                            ])
                                            ->default('multiple_choice')
                                            ->required(),

                                        Forms\Components\TextInput::make('points')
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->required(),

                                        Forms\Components\TextInput::make('image_url')
                                            ->label('Image URL')
                                            ->url()
                                            ->columnSpan(2),

                                        Forms\Components\Textarea::make('explanation')
                                            ->label('Explanation (shown after answering)')
                                            ->rows(2)
                                            ->columnSpan(2),
                                    ]),

                                Forms\Components\Repeater::make('options')
                                    ->relationship('options')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('option_text')
                                                    ->label('Option')
                                                    ->required()
                                                    ->columnSpan(2),

                                                Forms\Components\Toggle::make('is_correct')
                                                    ->label('Correct')
                                                    ->inline(false),
                                            ]),
                                    ])
                                    ->orderColumn('order')
                                    ->reorderable()
                                    ->collapsible()
                                    ->collapsed()
                                    ->itemLabel(fn(array $state): ?string => $state['option_text'] ?? 'Option')
                                    ->addActionLabel('Add Option')
                                    ->minItems(2)
                                    ->defaultItems(4),
                            ])
                            ->orderColumn('order')
                            ->reorderable()
                            ->collapsible()
                            ->collapsed()
                            ->itemLabel(fn(array $state): ?string => $state['question_text'] ?? 'Question')
                            ->addActionLabel('Add Question')
                            ->defaultItems(1)
                            ->columnSpan(2),
                    ])
                    ->collapsible()
                    ->collapsed(fn(?Assessment $record) => $record !== null), // Collapse if editing existing

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('is_published')
                                    ->label('Published')
                                    ->helperText('Make visible to students'),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'test' => 'primary',
                        'quiz' => 'success',
                        'practice' => 'info',
                        'exam' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('questions_count')
                    ->label('Questions')
                    ->counts('questions')
                    ->sortable(),

                Tables\Columns\TextColumn::make('attempts_count')
                    ->label('Attempts')
                    ->counts('attempts')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('section.name')
                    ->label('Faculty')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('certification.name')
                    ->label('Department')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('classroom.name')
                    ->label('Class')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Teacher')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'test' => 'Test',
                        'quiz' => 'Quiz',
                        'practice' => 'Practice',
                        'exam' => 'Exam',
                    ]),

                Tables\Filters\SelectFilter::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ]),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListAssessments::route('/'),
            'create' => Pages\CreateAssessment::route('/create'),
            'edit' => Pages\EditAssessment::route('/{record}/edit'),
        ];
    }
}

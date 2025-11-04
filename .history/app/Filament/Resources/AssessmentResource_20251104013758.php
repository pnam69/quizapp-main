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
    
    protected static ?string $navigationGroup = 'Assessment System';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $navigationLabel = 'Assessments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        Forms\Components\Select::make('type')
                            ->options([
                                'quiz' => 'Quiz',
                                'exam' => 'Exam',
                                'practice' => 'Practice',
                                'assignment' => 'Assignment',
                            ])
                            ->required(),
                        
                        Forms\Components\Select::make('difficulty')
                            ->options([
                                'easy' => 'Easy',
                                'medium' => 'Medium',
                                'hard' => 'Hard',
                            ])
                            ->required(),
                        
                        Forms\Components\TextInput::make('category')
                            ->maxLength(255),
                    ])->columns(2),
                
                Forms\Components\Section::make('Assignment')
                    ->schema([
                        Forms\Components\Select::make('teacher_id')
                            ->relationship('teacher', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Teacher'),
                        
                        Forms\Components\Select::make('classroom_id')
                            ->relationship('classroom', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Classroom (Leave empty for all)'),
                        
                        Forms\Components\Select::make('section_id')
                            ->relationship('section', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Section (Leave empty for all)'),
                        
                        Forms\Components\Select::make('certification_id')
                            ->relationship('certification', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Certification'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('time_limit')
                            ->numeric()
                            ->suffix('minutes')
                            ->label('Time Limit (leave empty for no limit)'),
                        
                        Forms\Components\TextInput::make('passing_score')
                            ->numeric()
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100)
                            ->label('Passing Score'),
                        
                        Forms\Components\TextInput::make('attempts_allowed')
                            ->numeric()
                            ->default(-1)
                            ->helperText('-1 for unlimited attempts')
                            ->label('Attempts Allowed'),
                        
                        Forms\Components\Toggle::make('shuffle_questions')
                            ->label('Shuffle Questions')
                            ->default(false),
                        
                        Forms\Components\Toggle::make('shuffle_options')
                            ->label('Shuffle Answer Options')
                            ->default(false),
                        
                        Forms\Components\Toggle::make('show_correct_answers')
                            ->label('Show Correct Answers After Submission')
                            ->default(true),
                    ])->columns(3),
                
                Forms\Components\Section::make('Availability')
                    ->schema([
                        Forms\Components\DateTimePicker::make('available_from')
                            ->label('Available From'),
                        
                        Forms\Components\DateTimePicker::make('available_until')
                            ->label('Available Until'),
                        
                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->default(false),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->colors([
                        'success' => 'easy',
                        'warning' => 'medium',
                        'danger' => 'hard',
                    ])
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('total_questions')
                    ->label('Questions')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('total_points')
                    ->label('Points')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('classroom.name')
                    ->label('Classroom')
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('section.name')
                    ->label('Section')
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'quiz' => 'Quiz',
                        'exam' => 'Exam',
                        'practice' => 'Practice',
                        'assignment' => 'Assignment',
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
                
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
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
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

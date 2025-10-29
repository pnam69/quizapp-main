<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResource\Pages;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;
    protected static ?string $navigationIcon = 'heroicon-s-fire';
    protected static ?string $navigationGroup = 'Quiz Management';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),

                Forms\Components\Select::make('quiz_header_id')
                    ->relationship('quiz_header', 'id')
                    ->required(),

                Forms\Components\Select::make('domain_id')
                    ->relationship('domain', 'name')
                    ->required(),

                Forms\Components\Select::make('question_id')
                    ->relationship('question', 'id')
                    ->required(),

                Forms\Components\TextInput::make('answer_id')
                    ->numeric()
                    ->required(),

                Forms\Components\Toggle::make('is_correct')->required(),

                // Many-to-many Sections
                Forms\Components\Select::make('sections')
                    ->label('Sections')
                    ->relationship('sections', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->nullable(),

                // Many-to-many Certifications
                Forms\Components\Select::make('certifications')
                    ->label('Certifications')
                    ->relationship('certifications', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->sortable(),
                Tables\Columns\TextColumn::make('quiz_header.id')->sortable(),
                Tables\Columns\TextColumn::make('domain.name')->sortable(),
                Tables\Columns\TextColumn::make('question.id')->sortable(),
                Tables\Columns\TextColumn::make('answer_id')->numeric()->sortable(),
                Tables\Columns\IconColumn::make('is_correct')->boolean(),
                Tables\Columns\TagsColumn::make('sections.name')->label('Sections'),
                Tables\Columns\TagsColumn::make('certifications.name')->label('Certifications'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}

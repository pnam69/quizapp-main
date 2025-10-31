<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers\AnswersRelationManager;
use App\Models\Question;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;
    protected static ?string $navigationIcon = 'heroicon-s-puzzle-piece';
    protected static ?string $navigationGroup = 'Quiz Management';
    protected static ?int $navigationSort = 4;
    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('domain_id')
                    ->relationship('domain', 'name')
                    ->preload()
                    ->required()
                    ->label('Domain')
                    ->placeholder('Select domain'),

                Forms\Components\Select::make('level')
                    ->options([
                        1 => 'Easy',
                        2 => 'Medium',
                        3 => 'Hard',
                    ])
                    ->required()
                    ->label('Difficulty'),

                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->required(),

                Forms\Components\Textarea::make('question')
                    ->label('Question Text')
                    ->required()
                    ->maxLength(65535),

                Forms\Components\Textarea::make('explanation')
                    ->label('Explanation / Notes')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')->wrap(),
                TextColumn::make('domain.name')->label('Domain')->sortable()->searchable(),
                TextColumn::make('level')
                    ->badge(fn(int $state) => match ($state) {
                        1 => 'Easy',
                        2 => 'Medium',
                        3 => 'Hard',
                    })
                    ->sortable(),
                ToggleColumn::make('is_active')->label('Active'),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AnswersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}

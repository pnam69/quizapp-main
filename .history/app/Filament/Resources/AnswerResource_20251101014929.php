<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnswerResource\Pages;
use App\Models\Answer;

use App\Models\Question;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Collection;

class AnswerResource extends Resource
{
    protected static ?string $model = Answer::class;

    protected static ?string $navigationIcon = 'heroicon-s-check';
    protected static ?string $navigationGroup = 'Quiz Management';
    protected static ?int $navigationSort = 5;
    protected static bool $shouldRegisterNavigation = true;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('question_id')
                    ->relationship('question', 'question')
                    ->preload()
                    ->required()
                    ->label('Question'),

                Forms\Components\Textarea::make('answer')
                    ->label('Answer')
                    ->required()
                    ->maxLength(65535),

                Forms\Components\Toggle::make('is_checked')
                    ->label('Correct Answer')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        // Keep table minimal or empty, we will use grouped cards
        return $table
            ->columns([])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnswers::route('/'),
            'create' => Pages\CreateAnswer::route('/create'),
            'edit' => Pages\EditAnswer::route('/{record}/edit'),
        ];
    }
}

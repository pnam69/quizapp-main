<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers\AnswersRelationManager;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;
    protected static ?string $navigationIcon = 'heroicon-s-puzzle-piece';
    protected static ?string $navigationGroup = 'Quiz Management';
    protected static ?int $navigationSort = 4;
    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('domain_id')
                ->relationship('domain', 'name')
                ->preload()
                ->required()
                ->label('Domain'),

            Forms\Components\Select::make('level')
                ->options([
                    1 => 'Easy',
                    2 => 'Medium',
                    3 => 'Hard',
                ])
                ->required()
                ->label('Difficulty Level'),

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

            // Optional: File upload if needed
            // SpatieMediaLibraryFileUpload::make('thumbnail')
            //     ->collection('questions')
            //     ->multiple()
            //     ->image()
            //     ->reorderable()
            //     ->label('Question Images'),

            // Inline answers as repeater
            Card::make()->schema([
                Repeater::make('answers')
                    ->relationship()
                    ->label('Answers')
                    ->schema([
                        Forms\Components\TextInput::make('answer')
                            ->required()
                            ->maxLength(255)
                            ->label('Answer Text'),
                        Forms\Components\Toggle::make('is_checked')
                            ->label('Correct?')
                            ->required(),
                    ])
                    ->columns(1)
                    ->createItemButtonLabel('Add Answer'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('question')->wrap(),
            Tables\Columns\TextColumn::make('domain.name')->label('Domain')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('level')
                ->badge(fn(int $state) => match ($state) {
                    1 => 'Easy',
                    2 => 'Medium',
                    3 => 'Hard',
                })
                ->sortable(),
            Tables\Columns\ToggleColumn::make('is_active'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AnswersRelationManager::class, // clean inline answer manager
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

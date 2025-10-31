<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Repeater;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-s-puzzle-piece';
    protected static ?string $navigationGroup = 'Quiz Management';
    protected static ?int $navigationSort = 4;

    protected static bool $shouldRegisterNavigation = true;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 2 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Forms\Components\Textarea::make('question')
                        ->label('Question')
                        ->required()
                        ->maxLength(65535),
                    Forms\Components\Textarea::make('explanation')
                        ->label('Explanation')
                        ->required()
                        ->maxLength(65535),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('thumbnail')
                        ->collection('questions')
                        ->label('Question Image')
                        ->image()
                        ->multiple()
                        ->reorderable(),
                ])->columns(1),

                Card::make([
                    Forms\Components\Select::make('domain_id')
                        ->relationship('domain', 'name')
                        ->preload()
                        ->required()
                        ->placeholder('Select Domain'),
                    Forms\Components\Select::make('level')
                        ->label('Difficulty Level')
                        ->options([
                            1 => 'Easy',
                            2 => 'Medium',
                            3 => 'Difficult'
                        ])
                        ->required(),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active?')
                        ->required(),
                ])->columns(3),

                Card::make([
                    Repeater::make('answers')
                        ->relationship('answers')
                        ->label('Answers')
                        ->minItems(2)
                        ->maxItems(6)
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('answer')
                                ->required()
                                ->placeholder('Answer text')
                                ->maxLength(255),
                            Forms\Components\Toggle::make('is_checked')
                                ->label('Correct?')
                                ->required(),
                        ])
                        ->createItemButtonLabel('Add another answer'),
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('Toggle Status')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->is_active = !$record->is_active;
                                $record->save();
                            }
                            Notification::make()
                                ->success()
                                ->title('Question Status toggled successfully!')
                                ->send();
                        })
                        ->icon('heroicon-m-arrows-right-left')
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            Domain\RelationManagers\AnswersRelationManager::class,
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

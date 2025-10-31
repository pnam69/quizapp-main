<?php

namespace App\Filament\Resources;

use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
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
                    ->label('Difficulty Level'),

                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->required(),

                Forms\Components\Textarea::make('question')
                    ->label('Question Text')
                    ->required()
                    ->maxLength(65535),

                SpatieMediaLibraryFileUpload::make('thumbnail')
                    ->collection('questions')
                    ->multiple()
                    ->image()
                    ->reorderable()
                    ->label('Question Images'),

                Forms\Components\Textarea::make('explanation')
                    ->label('Explanation / Notes')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        DeleteAction::make()
            ->action(function ($record) {
                $record->deleteQuestion(); // calls the model’s deleteQuestion()
            });

        DeleteBulkAction::make()
            ->action(function ($records) {
                foreach ($records as $record) {
                    $record->deleteQuestion();
                }
            });
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
            QuestionResource\RelationManagers\AnswersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create')->mutateFormDataUsing(function (array $data) {
                // Use model method
                $question = \App\Models\Question::createQuestion($data);
                return $question->toArray(); // populate form with created data
            }),
            'edit' => Pages\EditQuestion::route('/{record}/edit')->mutateFormDataUsing(function (array $data, $record) {
                // Use model method
                $record->updateQuestion($data);
                return $record->toArray();
            }),
        ];
    }
}

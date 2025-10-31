<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnswerResource\Pages;
use App\Models\Answer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;

class AnswerResource extends Resource
{
    protected static ?string $model = Answer::class;

    protected static ?string $navigationIcon = 'heroicon-s-light-bulb';
    protected static ?string $navigationGroup = 'Quiz Management';
    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 10 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('question_id')
                ->relationship('question', 'question')
                ->searchable()
                ->preload()
                ->required()
                ->label('Question'),

            Forms\Components\Textarea::make('answer')
                ->label('Answer Text')
                ->required()
                ->maxLength(65535),

            Forms\Components\Toggle::make('is_correct')
                ->label('Is Correct?')
                ->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question.question')
                    ->label('Question')
                    ->limit(60)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('answer')
                    ->label('Answer')
                    ->limit(80)
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_correct')
                    ->boolean()
                    ->label('Correct'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Created')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Updated')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('MarkCorrect')
                        ->label('Mark as Correct')
                        ->icon('heroicon-m-check-circle')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['is_correct' => true]);
                            }

                            Notification::make()
                                ->title('Answers marked as correct.')
                                ->success()
                                ->send();
                        }),
                ]),
            ]);
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

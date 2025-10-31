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

    protected static ?string $navigationIcon = 'heroicon-s-collection';
    protected static ?string $navigationGroup = 'Quiz Management';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('question_id')
                    ->relationship('question', 'question')
                    ->label('Question')
                    ->required()
                    ->searchable(),

                Forms\Components\Textarea::make('answer')
                    ->label('Answer Text')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Toggle::make('is_checked')
                    ->label('Correct?'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question.question')
                    ->label('Question')
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('answer')
                    ->label('Answer')
                    ->wrap(),

                Tables\Columns\IconColumn::make('is_checked')
                    ->label('Correct')
                    ->boolean()
                    ->trueIcon('heroicon-s-check')
                    ->falseIcon('heroicon-s-x')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('question')
                    ->relationship('question', 'question'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('Toggle Correct')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $record->is_checked = !$record->is_checked;
                            $record->save();
                        }
                        Notification::make()
                            ->success()
                            ->title('Answer correct status toggled!')
                            ->send();
                    })
                    ->icon('heroicon-m-arrows-right-left'),
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

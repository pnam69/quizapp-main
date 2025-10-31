<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnswerResource\Pages;
use App\Models\Answer;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class AnswerResource extends Resource
{
    protected static ?string $model = Answer::class;

    protected static ?string $navigationIcon = '';
    protected static ?string $navigationGroup = 'Quiz Management';
    protected static ?int $navigationSort = 6;

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
                Forms\Components\Select::make('question_id')
                    ->relationship('question', 'question')
                    ->label('Select Question')
                    ->required()
                    ->placeholder('Choose question'),

                Repeater::make('answers')
                    ->relationship('question.answers') // ensures proper relation
                    ->schema([
                        Forms\Components\Textarea::make('answer')
                            ->label('Answer Text')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_checked')
                            ->label('Correct?'),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->label('Answers for this Question'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question.question')
                    ->label('Question')
                    ->wrap(),

                Tables\Columns\TextColumn::make('answers')
                    ->label('Answers')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->question->answers
                            ->map(fn($a) => ($a->is_checked ? '✅ ' : '❌ ') . $a->answer)
                            ->implode('<br>');
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('Toggle Correct')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->is_checked = !$record->is_checked;
                                $record->save();
                            }
                            Notification::make()
                                ->success()
                                ->title('Answer Correct status toggled!')
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
            // You can add relation managers if needed
        ];
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

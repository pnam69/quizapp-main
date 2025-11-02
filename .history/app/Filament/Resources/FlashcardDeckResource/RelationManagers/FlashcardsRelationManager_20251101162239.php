<?php

namespace App\Filament\Resources\FlashcardDeckResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Flashcard;

class FlashcardsRelationManager extends RelationManager
{
    protected static string $relationship = 'flashcards';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('deck_id')
                    ->default(fn() => $this->ownerRecord->id),
                Forms\Components\Hidden::make('user_id')
                    ->default(fn() => $this->ownerRecord->user_id),
                Forms\Components\Textarea::make('front_content')
                    ->required()
                    ->label('Question/Front')
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->placeholder('Enter the question or content for the front of the card'),
                Forms\Components\Textarea::make('back_content')
                    ->required()
                    ->label('Answer/Back')
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->placeholder('Enter the answer or content for the back of the card'),
                Forms\Components\TextInput::make('difficulty_level')
                    ->default('medium')
                    ->datalist(['easy', 'medium', 'hard'])
                    ->placeholder('easy, medium, or hard'),
                Forms\Components\TextInput::make('tags')
                    ->placeholder('Comma-separated tags (optional)'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('front_content')
            ->columns([
                Tables\Columns\TextColumn::make('front_content')
                    ->label('Question')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('back_content')
                    ->label('Answer')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('difficulty_level')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('difficulty_level')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}

<?php

namespace App\Filament\Resources\QuestionResource\RelationManagers;

use App\Models\Answer;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AnswersRelationManager extends RelationManager
{
    protected static string $relationship = 'answers';
    protected static ?string $recordTitleAttribute = 'answer';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('answer')
                ->label('Answer Text')
                ->required()
                ->maxLength(255),
            Forms\Components\Toggle::make('is_checked')
                ->label('Correct?')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('answer')->wrap(),
            Tables\Columns\IconColumn::make('is_checked')->boolean()->label('Correct'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
        ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}

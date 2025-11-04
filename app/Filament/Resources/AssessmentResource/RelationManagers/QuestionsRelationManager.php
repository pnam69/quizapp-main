<?php

namespace App\Filament\Resources\AssessmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('question_text')
                    ->required()
                    ->label('Question')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\Select::make('question_type')
                    ->options([
                        'multiple_choice' => 'Multiple Choice',
                        'true_false' => 'True/False',
                        'short_answer' => 'Short Answer',
                    ])
                    ->required()
                    ->default('multiple_choice'),

                Forms\Components\TextInput::make('points')
                    ->numeric()
                    ->required()
                    ->default(1)
                    ->minValue(0),

                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->label('Order (for sorting)'),

                Forms\Components\Textarea::make('explanation')
                    ->label('Explanation (shown after submission)')
                    ->rows(2)
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_required')
                    ->label('Required Question')
                    ->default(true),

                Forms\Components\Section::make('Answer Options')
                    ->schema([
                        Forms\Components\Repeater::make('options')
                            ->relationship('options')
                            ->schema([
                                Forms\Components\TextInput::make('option_text')
                                    ->required()
                                    ->label('Option Text'),

                                Forms\Components\Toggle::make('is_correct')
                                    ->label('Correct Answer')
                                    ->default(false),

                                Forms\Components\TextInput::make('order')
                                    ->numeric()
                                    ->default(0)
                                    ->label('Order'),
                            ])
                            ->columns(3)
                            ->defaultItems(4)
                            ->addActionLabel('Add Option')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => $state['option_text'] ?? null),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question_text')
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->width(50),

                Tables\Columns\TextColumn::make('question_text')
                    ->label('Question')
                    ->wrap()
                    ->limit(100)
                    ->searchable(),

                Tables\Columns\TextColumn::make('question_type')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => str_replace('_', ' ', ucfirst($state))),

                Tables\Columns\TextColumn::make('points')
                    ->sortable(),

                Tables\Columns\TextColumn::make('options_count')
                    ->counts('options')
                    ->label('Options'),

                Tables\Columns\IconColumn::make('is_required')
                    ->boolean(),
            ])
            ->filters([
                //
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
            ->reorderable('order')
            ->defaultSort('order');
    }
}

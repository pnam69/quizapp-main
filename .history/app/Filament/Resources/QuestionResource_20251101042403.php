<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Models\Question;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Resources\Form;
use Filament\Resources\Table;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationLabel = 'Questions';
    protected static ?string $pluralLabel = 'Questions';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('domain_id')
                    ->relationship('domain', 'name')
                    ->required(),
                Forms\Components\TextInput::make('question')->required(),
                Forms\Components\Textarea::make('explanation'),
                Forms\Components\Toggle::make('is_active')->default(true),
                Forms\Components\Select::make('level')
                    ->options([
                        1 => 'Easy',
                        2 => 'Medium',
                        3 => 'Hard',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('domain.name')->label('Domain'),
                Tables\Columns\TextColumn::make('level'),
                Tables\Columns\BooleanColumn::make('is_active'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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

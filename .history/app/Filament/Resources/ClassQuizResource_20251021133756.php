<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassQuizResource\Pages;
use App\Filament\Resources\ClassQuizResource\RelationManagers;
use App\Models\ClassQuiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassQuizResource extends Resource
{
    protected static ?string $model = ClassQuiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('classroom.name')->label('Class'),
            Tables\Columns\TextColumn::make('quiz.name')->label('Quiz'),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(), // Clicking opens details
        ]);
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassQuizzes::route('/'),
            'create' => Pages\CreateClassQuiz::route('/create'),
            'edit' => Pages\EditClassQuiz::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassCourseResource\Pages;
use App\Models\ClassCourse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ClassCourseResource\RelationManagers\StudentsRelationManager;

class ClassCourseResource extends Resource
{
    protected static ?string $model = ClassCourse::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Class Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('course_year')
                    ->label('Course Year')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('main_teacher_id')
                    ->label('Main Teacher')
                    ->relationship('mainTeacher', 'name')
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Class Name'),
                Tables\Columns\TextColumn::make('course_year')->label('Course Year'),
                Tables\Columns\TextColumn::make('mainTeacher.name')->label('Main Teacher'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassCourses::route('/'),
            'create' => Pages\CreateClassCourse::route('/create'),
            'view' => Pages\ViewClassCourse::route('/{record}'),
            'edit' => Pages\EditClassCourse::route('/{record}/edit'),
        ];
    }
    public static function getRelations(): array
{
    return [
        StudentsRelationManager::class,
    ];
}
    
}

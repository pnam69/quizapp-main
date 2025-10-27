<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestResource\Pages;
use App\Models\Question;
use App\Models\Test;
use App\Models\Certification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestResource extends Resource
{?
    protected static ?string $model = \App\Models\Test::class;

    protected static ?string $navigationGroup = 'Quizzes';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $navigationLabel = 'Tests';
    protected static ?string $pluralModelLabel = 'Tests';
    protected static ?string $modelLabel = 'Test';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Test Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('certification_id')
                    ->label('Certification')
                    ->options(Certification::pluck('name', 'id'))
                    ->required()
                    ->native(false),

                Forms\Components\MultiSelect::make('question_ids')
                    ->label('Select Questions')
                    ->options(Question::pluck('question', 'id'))
                    ->required()
                    ->helperText('Choose the exact questions that belong to this test.')
                    ->columns(2),

                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    // NOTE: correct signature using Filament\Tables\Table
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Test Name')->searchable(),
                Tables\Columns\TextColumn::make('certification.name')->label('Certification'),
                Tables\Columns\TextColumn::make('question_count')
                    ->label('Questions')
                    ->getStateUsing(fn($record) => count($record->question_ids ?? [])),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTests::route('/'),
            'create' => Pages\CreateTest::route('/create'),
            'edit' => Pages\EditTest::route('/{record}/edit'),
        ];
    }
}

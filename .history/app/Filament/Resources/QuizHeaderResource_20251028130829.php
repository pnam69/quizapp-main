<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizHeaderResource\Pages;
use App\Models\QuizHeader;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuizHeaderResource extends Resource
{
    protected static ?string $model = QuizHeader::class;
    protected static ?string $navigationIcon = 'heroicon-s-rocket-launch';
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

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),

                Forms\Components\Textarea::make('domains')->maxLength(65535)->columnSpanFull(),
                Forms\Components\Textarea::make('difficulty')->maxLength(65535)->columnSpanFull(),

                Forms\Components\Toggle::make('learningmode')->required(),
                Forms\Components\Toggle::make('completed')->required(),

                Forms\Components\TextInput::make('quiz_size')->numeric()->required(),
                Forms\Components\TextInput::make('score')->numeric()->default(0)->required(),

                Forms\Components\Textarea::make('questions_taken')->maxLength(65535)->columnSpanFull(),

                // Many-to-many Sections
                Forms\Components\Select::make('sections')
                    ->label('Sections')
                    ->relationship('sections', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->nullable(),

                // Many-to-many Certifications
                Forms\Components\Select::make('certifications')
                    ->label('Certifications')
                    ->relationship('certifications', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->sortable(),
                Tables\Columns\TagsColumn::make('sections.name')->label('Sections'),
                Tables\Columns\TagsColumn::make('certifications.name')->label('Certifications'),
                Tables\Columns\IconColumn::make('learningmode')->boolean(),
                Tables\Columns\IconColumn::make('completed')->boolean(),
                Tables\Columns\TextColumn::make('score')->numeric()->sortable()->suffix('%'),
                Tables\Columns\TextColumn::make('quiz_size')->numeric()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
            ])
            ->actions([
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
            'index' => Pages\ListQuizHeaders::route('/'),
            'create' => Pages\CreateQuizHeader::route('/create'),
            'edit' => Pages\EditQuizHeader::route('/{record}/edit'),
        ];
    }
}

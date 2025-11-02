<?php

namespace App\Filament\Member\Resources;

use App\Filament\Member\Resources\FlashcardDeckResource\Pages;
use App\Filament\Member\Resources\FlashcardDeckResource\RelationManagers;
use App\Models\FlashcardDeck;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class FlashcardDeckResource extends Resource
{
    protected static ?string $model = FlashcardDeck::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(fn() => Auth::guard('member')->id()),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter deck title'),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->placeholder('Describe your flashcard deck'),
                Forms\Components\Select::make('visibility')
                    ->options([
                        'private' => 'Private (only you can see)',
                        'public' => 'Public (anyone can study)',
                    ])
                    ->default('private')
                    ->required(),
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->directory('flashcard-covers')
                    ->visibility('public'),
                Forms\Components\Hidden::make('card_count')
                    ->default(0),
                Forms\Components\Toggle::make('is_published')
                    ->label('Publish deck')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->where('user_id', Auth::guard('member')->id()))
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('visibility')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'public' => 'success',
                        'private' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('card_count')
                    ->label('Cards')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('cover_image')
                    ->circular(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('visibility')
                    ->options([
                        'private' => 'Private',
                        'public' => 'Public',
                    ]),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),
            ])
            ->actions([
                Tables\Actions\Action::make('study')
                    ->label('Study')
                    ->icon('heroicon-o-academic-cap')
                    ->color('success')
                    ->url(fn(FlashcardDeck $record): string => route('filament.member.pages.flashcard-study-page', ['deckId' => $record->id])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No flashcard decks yet')
            ->emptyStateDescription('Create your first flashcard deck to start studying.')
            ->emptyStateIcon('heroicon-o-book-open');
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
            'index' => Pages\ListFlashcardDecks::route('/'),
            'create' => Pages\CreateFlashcardDeck::route('/create'),
            'edit' => Pages\EditFlashcardDeck::route('/{record}/edit'),
        ];
    }
}

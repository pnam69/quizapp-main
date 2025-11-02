<?php

namespace App\Filament\Member\Pages;

use App\Models\FlashcardDeck;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Action;
use Filament\Tables\Contracts\HasTable;

class MyFlashcardDecks extends Page implements Tables\Contracts\HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static string $view = 'filament.member.pages.my-flashcard-decks';

    protected static ?string $navigationLabel = 'My Flashcards';

    // Hidden from navigation - quizzes will now be converted to flashcards
    protected static bool $shouldRegisterNavigation = false;

    protected static ?int $navigationSort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return FlashcardDeck::where('user_id', auth()->id())
                    ->orWhere('visibility', 'public');
            })
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
            ->actions([
                Tables\Actions\Action::make('study')
                    ->label('Study')
                    ->icon('heroicon-o-academic-cap')
                    ->color('success')
                    ->url(fn(FlashcardDeck $record): string => route('filament.member.pages.flashcard-study-page', ['deckId' => $record->id])),
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->color('warning')
                    ->url(fn(FlashcardDeck $record): string => "/admin/flashcard-decks/{$record->id}/edit")
                    ->visible(fn(): bool => Auth::user()?->is_admin),
            ])
            ->emptyStateHeading('No flashcard decks yet')
            ->emptyStateDescription('Create your first flashcard deck to start studying.')
            ->emptyStateIcon('heroicon-o-book-open');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_deck')
                ->label('Create Deck')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->url('/admin/flashcard-decks/create')
                ->visible(fn(): bool => Auth::user()?->is_admin),
            Action::make('create_member_deck')
                ->label('Create Deck')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->action(function () {
                    // Create a deck for the current member user
                    $user = auth()->user();
                    FlashcardDeck::create([
                        'user_id' => $user->id,
                        'title' => 'My New Deck',
                        'description' => 'A new flashcard deck',
                        'visibility' => 'private',
                        'card_count' => 0,
                        'is_published' => false,
                    ]);

                    $this->redirect('/member/my-flashcard-decks');
                }),
        ];
    }
}

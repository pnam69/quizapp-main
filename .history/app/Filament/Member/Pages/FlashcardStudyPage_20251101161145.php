<?php

namespace App\Filament\Member\Pages;

use App\Models\Flashcard;
use App\Models\FlashcardDeck;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class FlashcardStudyPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static string $view = 'filament.member.pages.flashcard-study-page';

    protected static bool $shouldRegisterNavigation = false; // Hide from navigation

    public FlashcardDeck $deck;
    public $flashcards = [];
    public $currentCardIndex = 0;
    public $showAnswer = false;
    public $currentCard = null;

    public function mount($deckId): void
    {
        $this->deck = FlashcardDeck::findOrFail($deckId);

        // Check if user has access to this deck
        $user = Auth::guard('member')->user();
        if ($this->deck->user_id !== $user->id && $this->deck->visibility !== 'public') {
            abort(403, 'You do not have access to this flashcard deck.');
        }

        $this->loadFlashcards();
        $this->loadCurrentCard();
    }

    public function loadFlashcards(): void
    {
        $this->flashcards = Flashcard::where('deck_id', $this->deck->id)
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }

    public function loadCurrentCard(): void
    {
        if (count($this->flashcards) > 0 && isset($this->flashcards[$this->currentCardIndex])) {
            $this->currentCard = (object) $this->flashcards[$this->currentCardIndex];
        } else {
            $this->currentCard = null;
        }
        $this->showAnswer = false;
    }

    public function flipCard(): void
    {
        $this->showAnswer = !$this->showAnswer;
    }

    public function nextCard(): void
    {
        if ($this->currentCardIndex < count($this->flashcards) - 1) {
            $this->currentCardIndex++;
            $this->loadCurrentCard();
        } else {
            Notification::make()
                ->title('Deck Complete!')
                ->body('You have finished studying all cards in this deck.')
                ->success()
                ->send();
        }
    }

    public function previousCard(): void
    {
        if ($this->currentCardIndex > 0) {
            $this->currentCardIndex--;
            $this->loadCurrentCard();
        }
    }

    public function markDifficult(): void
    {
        // For now, just move to next card
        // TODO: Implement spaced repetition algorithm
        $this->nextCard();
    }

    public function markGood(): void
    {
        // For now, just move to next card
        // TODO: Implement spaced repetition algorithm
        $this->nextCard();
    }

    public function markEasy(): void
    {
        // For now, just move to next card
        // TODO: Implement spaced repetition algorithm
        $this->nextCard();
    }

    public function resetStudy(): void
    {
        $this->currentCardIndex = 0;
        $this->loadCurrentCard();

        Notification::make()
            ->title('Study Reset')
            ->body('Starting over from the beginning.')
            ->info()
            ->send();
    }

    public function getTitle(): string
    {
        return 'Study: ' . ($this->deck->title ?? 'Flashcards');
    }
}

<?php

namespace App\Filament\Member\Resources\FlashcardDeckResource\Pages;

use App\Filament\Member\Resources\FlashcardDeckResource;
use App\Models\Flashcard;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;

class FlashcardStudy extends Page
{
    protected static string $resource = FlashcardDeckResource::class;

    protected static string $view = 'filament.member.resources.flashcard-deck-resource.pages.flashcard-study';

    public $flashcards = [];
    public $currentCardIndex = 0;
    public $showAnswer = false;
    public $currentCard = null;

    public function mount(): void
    {
        $this->loadFlashcards();
        $this->loadCurrentCard();
    }

    public function loadFlashcards(): void
    {
        $user = auth()->user();

        // Only show flashcards from decks that belong to the user or are public
        $this->flashcards = Flashcard::where('deck_id', $this->record->id)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('deck', function ($deckQuery) {
                        $deckQuery->where('visibility', 'public');
                    });
            })
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
        // Implement spaced repetition logic for difficult cards
        // For now, just move to next card
        $this->nextCard();
    }

    public function markGood(): void
    {
        // Implement spaced repetition logic for good cards
        // For now, just move to next card
        $this->nextCard();
    }

    public function markEasy(): void
    {
        // Implement spaced repetition logic for easy cards
        // For now, just move to next card
        $this->nextCard();
    }

    public function resetStudy(): void
    {
        $this->currentCardIndex = 0;
        $this->loadCurrentCard();
    }
}

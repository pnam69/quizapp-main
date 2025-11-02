<?php

namespace App\Filament\Member\Resources\FlashcardDeckResource\Pages;

use App\Filament\Member\Resources\FlashcardDeckResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlashcardDecks extends ListRecords
{
    protected static string $resource = FlashcardDeckResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

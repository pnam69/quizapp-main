<?php

namespace App\Filament\Member\Resources\FlashcardDeckResource\Pages;

use App\Filament\Member\Resources\FlashcardDeckResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlashcardDeck extends EditRecord
{
    protected static string $resource = FlashcardDeckResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

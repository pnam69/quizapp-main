<?php

namespace App\Filament\Member\Resources\FlashcardDeckResource\Pages;

use App\Filament\Member\Resources\FlashcardDeckResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFlashcardDeck extends CreateRecord
{
    protected static string $resource = FlashcardDeckResource::class;
}

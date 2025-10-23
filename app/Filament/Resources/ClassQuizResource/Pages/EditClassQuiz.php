<?php

namespace App\Filament\Resources\ClassQuizResource\Pages;

use App\Filament\Resources\ClassQuizResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassQuiz extends EditRecord
{
    protected static string $resource = ClassQuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

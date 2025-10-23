<?php

namespace App\Filament\Resources\ClassQuizResource\Pages;

use App\Filament\Resources\ClassQuizResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassQuizzes extends ListRecords
{
    protected static string $resource = ClassQuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

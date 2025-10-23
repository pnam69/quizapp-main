<?php

namespace App\Filament\Resources\ClassCourseResource\Pages;

use App\Filament\Resources\ClassCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassCourses extends ListRecords
{
    protected static string $resource = ClassCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

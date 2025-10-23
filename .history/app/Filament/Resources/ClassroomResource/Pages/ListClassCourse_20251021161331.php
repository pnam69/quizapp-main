<?php

namespace App\Filament\Resources\ClassroomResource\Pages;

use App\Filament\Resources\ClassroomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassCourse extends ListRecords
{
    protected static string $resource = ClassCourseResourcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

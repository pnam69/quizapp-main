<?php

namespace App\Filament\Resources\ClassCourseResource\Pages;

use App\Filament\Resources\ClassCourseResourceeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassCourse extends EditRecord
{
    protected static string $resource = ClassCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

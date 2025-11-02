<?php

namespace App\Filament\Resources\HomeworkSubmissionResource\Pages;

use App\Filament\Resources\HomeworkSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomeworkSubmission extends EditRecord
{
    protected static string $resource = HomeworkSubmissionResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['score']) && $data['score'] !== null) {
            $data['status'] = 'graded';
            $data['graded_by'] = auth()->id();
            $data['graded_at'] = now();
        }

        return $data;
    }
}

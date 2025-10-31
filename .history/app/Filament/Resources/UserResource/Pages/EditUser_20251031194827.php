<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    protected function mutateFormDataBeforeSave(array $data): array
{
    if (isset($data['password']) && filled($data['password'])) {
        $data['password'] = bcrypt($data['password']);
    } else {
        unset($data['password']);
    }

    return $data;
}

}

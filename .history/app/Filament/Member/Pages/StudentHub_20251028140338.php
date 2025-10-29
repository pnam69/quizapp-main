<?php

namespace App\Filament\Member\Pages;

use App\Models\Hub;
use Filament\Pages\Page;

class StudentHub extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.member.pages.student-hub';
    protected static ?string $navigationLabel = 'My Study Hub';
    protected static ?string $title = 'Study Hub';

    public $hubs;

    public function mount()
    {
        $userId = auth()->id();

        // Fetch all hubs meant for everyone or assigned to the user
        $this->hubs = Hub::whereNull('user_id') // keep old hubs without assignment
            ->orWhereHas('users', function ($q) use ($userId) {
                $q->where('id', $userId);
            })
            ->latest()
            ->get();
    }
}

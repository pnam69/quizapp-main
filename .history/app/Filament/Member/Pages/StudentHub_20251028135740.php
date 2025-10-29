<?php

namespace App\Filament\Member\Pages;

use App\Models\Hub;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class StudentHub extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.member.pages.student-hub';
    protected static ?string $navigationLabel = 'My Study Hub';
    protected static ?string $title = 'Study Hub';

    public $hubs;

    public function mount()
    {
        // Optionally filter hubs per user or section
        $this->hubs = Hub::whereNull('user_id') // hubs meant for all
            ->orWhereHas('users', function ($q) {
                $q->where('id', auth()->id());
            })
            ->latest()
            ->get();
    }
}

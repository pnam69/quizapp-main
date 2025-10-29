<?php

namespace App\Filament\Member\Pages;

use App\Models\Hub;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class StudentHub extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text
    ';
    protected static string $view = 'filament.member.pages.student-hub';
    protected static ?string $navigationLabel = 'My Study Hub';
    protected static ?string $title = 'Study Hub';

    public $hubs;

    public function mount()
    {
        // Optionally filter hubs per user or section
        $this->hubs = Hub::query()
            ->where('user_id', auth()->id())
            ->orWhereNull('user_id')
            ->latest()
            ->get();
    }
}

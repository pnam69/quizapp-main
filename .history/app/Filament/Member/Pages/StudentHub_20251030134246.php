<?php

namespace App\Filament\Member\Pages;

use App\Models\Hub;
use Filament\Pages\Page;

$user = Auth::guard('member')->user();


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

        // Show hubs that either:
        //  - have no assignment (public / global hubs)
        //  - OR are explicitly assigned to this user (via hub_user pivot)
        $this->hubs = Hub::query()
            ->whereDoesntHave('users') // public hubs
            ->orWhereHas('users', fn($q) => $q->where('users.id', $userId)) // assigned to this user
            ->latest()
            ->get();
    }
}

<?php

namespace App\Filament\Member\Pages;

use App\Models\Hub;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class LearningHub extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.member.pages.learning-hub';
    protected static ?int $navigationSort = 4;

    public static function getNavigationLabel(): string
    {
        return __('messages.learning_hub');
    }

    public function getTitle(): string
    {
        return __('messages.learning_hub');
    }

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

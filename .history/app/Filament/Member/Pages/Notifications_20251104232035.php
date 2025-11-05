<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Notifications extends Page
{
    protected static string $view = 'filament.member.pages.notifications';

    public static ?string $navigationIcon = 'heroicon-o-bell';
    public static ?string $navigationLabel = 'Notifications';
    protected static ?int $navigationSort = 8;

    public $notifications;

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $this->notifications = $user->notifications()->latest()->get();
    }
}

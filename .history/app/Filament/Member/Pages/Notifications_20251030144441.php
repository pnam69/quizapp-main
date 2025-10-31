<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Notifications extends Page
{
    protected static string $view = 'filament.member.pages.notifications';

    public static ?string $navigationIcon = 'heroicon-o-bell';
    public static ?string $navigationLabel = 'Notifications';

    public $notifications;

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $this->notifications = Auth::guard('member')->user()->notifications()->latest()->get();
    }
}

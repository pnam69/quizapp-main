<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Notifications extends Page
{
    protected static string $view = 'filament.member.pages.notifications';

    public $notifications;

    public function mount()
    {
        $user = Auth::guard('member')->user();
        $this->notifications = $user->notifications()->latest()->get();
    }
}

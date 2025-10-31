<?php

namespace App\Filament\Member\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class ProfileSummary extends Widget
{
    protected static string $view = 'filament.member.widgets.profile-summary';

    public $sections;
    public $certifications;

    public function mount(): void
    {
        $user = Auth::guard('member')->user();
        $this->sections = $user->sections;
        $this->certifications = $user->certifications;
    }
}

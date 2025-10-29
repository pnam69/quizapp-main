<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use App\Models\Hub;
use Illuminate\Support\Facades\Auth;

class StudentHub extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Study Hub';
    protected static ?string $navigationLabel = 'My Study Hub';
    protected static string $view = 'filament.member.pages.student-hub';

    public $hubs;

    public function mount()
    {
        $user = Auth::user();

        // Filter hubs that belong to this student
        $this->hubs = Hub::query()
            ->where('user_id', $user->id)
            ->orWhere('section_id', $user->section_id ?? null)
            ->orWhere('certification_id', $user->certification_id ?? null)
            ->latest()
            ->get();
    }
}

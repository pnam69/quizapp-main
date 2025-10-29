<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;

class StudentHub extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static string $view = 'filament.member.pages.student-hub';
    protected static ?string $title = 'Student Hub';
    protected static ?string $navigationLabel = 'Student Hub';
    protected static ?string $navigationGroup = 'Learning';
}

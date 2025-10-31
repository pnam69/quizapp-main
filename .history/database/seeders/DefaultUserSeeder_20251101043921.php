<?php

use App\Models\User;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\Certification;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

// Create or update the user
$user = User::updateOrCreate(
    ['email' => 'user1@example.com'],
    [
        'name' => 'User One',
        'password' => Hash::make('password123'),
        'is_admin' => 0,
        'is_active' => 1,
        'email_verified_at' => Carbon::parse('2025-10-31 14:56:49'), // your timestamp
    ]
);

// Assign Classroom(s)
$classroom = Classroom::where('name', '1st Year - Semester 1')->first();
if ($classroom) {
    $user->classroom_id = $classroom->id;
}

// Assign Section(s)
$sectionNames = ['Information Technology', 'Geography Section'];
$sections = Section::whereIn('name', $sectionNames)->pluck('id')->toArray();
$user->sections()->sync($sections); // assuming User has Many-to-Many sections

// Assign Certifications
$certNames = ['CISSP', 'CCNA'];
$certs = Certification::whereIn('name', $certNames)->pluck('id')->toArray();
$user->certifications()->sync($certs); // assuming User has Many-to-Many certifications

// Save everything
$user->save();
/ or ['super_admin'] if you want admin role

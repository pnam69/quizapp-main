<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user1@example.com'], // avoid duplicates
            [
                'name' => 'User One',
                'password' => Hash::make('password123'), // replace with your desired password
                'is_admin' => 0, // set to 1 if admin
                'is_active' => 1,
            ]
        );
    }
}

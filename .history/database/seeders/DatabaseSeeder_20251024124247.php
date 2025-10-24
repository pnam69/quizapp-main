<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,        // create users first
            ClassroomsTableSeeder::class,
            QuizHeadersTableSeeder::class,
            QuotesTableSeeder::class,       // quotes run after users exist
            // add other seeders here in required order
        ]);
    }
}

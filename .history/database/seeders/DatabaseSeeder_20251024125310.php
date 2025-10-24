<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure at least one user exists so QuoteSeeder won't fail
        if (\App\Models\User::count() === 0) {
            \App\Models\User::factory()->create();
        }

        $this->call([
            QuoteSeeder::class,
            SectionsTableSeeder::class,
            CertificationsTableSeeder::class,
            DomainsTableSeeder::class,
            QuestionsSeeder::class,
        ]);
    }
}

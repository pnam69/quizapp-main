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
        // ensure a user exists so seeders that reference users won't fail
        \App\Models\User::factory()->create();

        $this->call(QuoteSeeder::class);
        $this->call(SectionsTableSeeder::class);
        $this->call(CertificationsTableSeeder::class);
        $this->call(DomainsTableSeeder::class);
        $this->call(QuestionsSeeder::class);

        }
}

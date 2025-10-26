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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);

        // Create the admin user
        $user = User::factory()->create([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'is_admin' => 1,
            'is_active' => 1,
        ]);
        $this->call(QuoteSeeder::class);
        $this->call(ClassroomSeeder::class);
        $this->call(SectionsTableSeeder::class);
        $this->call(CertificationsTableSeeder::class);
        $this->call(DomainsTableSeeder::class);
        $this->call(QuestionsSeeder::class);
    }
}

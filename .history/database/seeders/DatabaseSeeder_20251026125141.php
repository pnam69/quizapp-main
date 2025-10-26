<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Make sure the role exists
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

        // Attach the role
        $user->assignRole($superAdminRole);

        // Now seed the rest
        $this->call([
            QuoteSeeder::class,
            ClassroomSeeder::class,
            SectionsTableSeeder::class,
            CertificationsTableSeeder::class,
            DomainsTableSeeder::class,
            QuestionsSeeder::class,
        ]);
    }
}

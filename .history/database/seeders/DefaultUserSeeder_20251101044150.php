<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\Certification;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    public function run()
    {
        // Ensure roles exist
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // Create user1
        $user = User::firstOrCreate(
            ['email' => 'user1@example.com'],
            [
                'name' => 'User One',
                'password' => Hash::make('password123'),
                'is_admin' => 0,
                'is_active' => 1,
                'email_verified_at' => now(),
            ]
        );

        // Assign role
        $user->syncRoles(['user']);

        // Assign classrooms
        $classroom = Classroom::firstOrCreate(['name' => '1st Year - Semester 1']);
        $user->classrooms()->sync([$classroom->id]);

        // Assign sections
        $sectionIT = Section::firstOrCreate(['name' => 'Information Technology']);
        $sectionGeo = Section::firstOrCreate(['name' => 'Geography Section']);
        $user->sections()->sync([$sectionIT->id, $sectionGeo->id]);

        // Assign certifications
        $certCISSP = Certification::firstOrCreate(['name' => 'CISSP']);
        $certCCNA  = Certification::firstOrCreate(['name' => 'CCNA']);
        $user->certifications()->sync([$certCISSP->id, $certCCNA->id]);

        $this->command->info('Default user1 created with roles, classrooms, sections, and certifications.');
    }
}

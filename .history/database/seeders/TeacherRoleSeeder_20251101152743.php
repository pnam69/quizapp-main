<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TeacherRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Teacher role
        $teacherRole = Role::firstOrCreate(
            ['name' => 'teacher'],
            ['guard_name' => 'web']
        );

        // Define permissions for teachers
        // Teachers can manage most content but with limitations
        $teacherPermissions = [
            // Quiz Management - Full access
            'view_any_quiz',
            'view_quiz',
            'create_quiz',
            'update_quiz',
            'delete_quiz', // Can delete their own quizzes
            'replicate_quiz',
            
            // Question Management - Full access
            'view_any_question',
            'view_question',
            'create_question',
            'update_question',
            'delete_question',
            'replicate_question',
            
            // Answer Management - Full access
            'view_any_answer',
            'view_answer',
            'create_answer',
            'update_answer',
            'delete_answer',
            
            // Test Management - Full access
            'view_any_test',
            'view_test',
            'create_test',
            'update_test',
            'delete_test',
            'replicate_test',
            
            // Quiz Header - Full access
            'view_any_quiz::header',
            'view_quiz::header',
            'create_quiz::header',
            'update_quiz::header',
            'delete_quiz::header',
            
            // Section Management - View and Create only
            'view_any_section',
            'view_section',
            'create_section',
            'update_section',
            
            // Classroom Management - Full access to assigned classrooms
            'view_any_classroom',
            'view_classroom',
            'create_classroom',
            'update_classroom',
            
            // Hub/Resources - Can create and manage their own
            'view_any_hub',
            'view_hub',
            'create_hub',
            'update_hub',
            // NOTE: NOT delete_any_hub - can't delete other teachers' resources
            
            // Certification - View and create
            'view_any_certification',
            'view_certification',
            'create_certification',
            
            // User Management - Limited (view students, can't delete)
            'view_any_user',
            'view_user',
            // NOTE: NO create_user, update_user, delete_user, delete_any_user
            
            // Domain - View only
            'view_any_domain',
            'view_domain',
            
            // Quote - View only
            'view_any_quote',
            'view_quote',
        ];

        // Create permissions if they don't exist and assign to teacher role
        foreach ($teacherPermissions as $permission) {
            $perm = Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
            
            if (!$teacherRole->hasPermissionTo($perm)) {
                $teacherRole->givePermissionTo($perm);
            }
        }

        $this->command->info('Teacher role created successfully with appropriate permissions!');
        $this->command->info('Teachers can:');
        $this->command->info('✓ Manage quizzes, questions, and tests');
        $this->command->info('✓ Create and manage classrooms');
        $this->command->info('✓ Create study resources (hubs)');
        $this->command->info('✓ View students and their progress');
        $this->command->info('✓ View analytics and reports');
        $this->command->info('');
        $this->command->warn('Teachers CANNOT:');
        $this->command->warn('✗ Delete students or other users');
        $this->command->warn('✗ Delete other teachers\' resources');
        $this->command->warn('✗ Manage system-wide settings');
        $this->command->warn('✗ Access super admin functions');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Models\User;
use App\Models\Quiz;
use App\Models\QuizHeader;

class DemoClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $quiz = Quiz::firstOrCreate(['name' => 'Sample Quiz']);

        foreach (['Class 1', 'Class 2'] as $name) {
            $class = Classroom::firstOrCreate(['name' => $name]);
            for ($i = 1; $i <= 10; $i++) {
                $u = User::create([
                    'name' => "{$name} Student {$i}",
                    'email' => strtolower(str_replace(' ', '', $name))."{$i}@example.test",
                    'password' => bcrypt('password'),
                    'classroom_id' => $class->id,
                    'age' => rand(14, 22),
                    'courses' => 'Math,Science',
                ]);

                QuizHeader::create([
                    'user_id' => $u->id,
                    'quiz_id' => $quiz->id,
                    'classroom_id' => $class->id,
                    'score' => rand(50, 100),
                ]);
            }
        }
    }
}
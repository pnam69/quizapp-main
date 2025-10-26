<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $years = ['1st Year', '2nd Year', '3rd Year'];
        $semesters = ['Semester 1', 'Semester 2'];

        foreach ($years as $year) {
            foreach ($semesters as $semester) {
                Classroom::create([
                    'name' => "{$year} - {$semester}",
                    'year' => $year,
                    'semester' => $semester,
                    'is_active' => true,
                ]);
            }
        }
    }
}

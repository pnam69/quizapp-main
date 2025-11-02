<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Test;
use App\Models\Homework;
use App\Models\HomeworkSubmission;
use App\Models\QuizHeader;
use App\Models\QuizAnswer;
use App\Models\Hub;
use App\Models\Question;
use App\Models\Section;
use App\Models\Certification;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MockDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting mock data seeding...');

        // Create additional teachers
        $this->createTeachers();

        // Create additional students
        $this->createStudents();

        // Create tests/quizzes
        $this->createTests();

        // Create homework assignments
        $this->createHomework();

        // Create homework submissions
        $this->createHomeworkSubmissions();

        // Create quiz attempts
        $this->createQuizAttempts();

        // Create study materials
        $this->createStudyMaterials();

        $this->command->info('Mock data seeding completed!');
    }

    private function createTeachers()
    {
        $teachers = [
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@school.edu',
                'subject' => 'Information Security'
            ],
            [
                'name' => 'Prof. Michael Chen',
                'email' => 'michael.chen@school.edu',
                'subject' => 'Network Security'
            ],
            [
                'name' => 'Dr. Emily Rodriguez',
                'email' => 'emily.rodriguez@school.edu',
                'subject' => 'Cybersecurity'
            ],
            [
                'name' => 'Mr. David Thompson',
                'email' => 'david.thompson@school.edu',
                'subject' => 'Ethical Hacking'
            ],
        ];

        foreach ($teachers as $teacherData) {
            $teacher = User::create([
                'name' => $teacherData['name'],
                'email' => $teacherData['email'],
                'password' => Hash::make('password123'),
                'is_admin' => 1,
                'is_active' => 1,
                'email_verified_at' => now(),
            ]);

            // Assign teacher role
            $teacher->assignRole('super_admin');

            // Assign to all classrooms (teachers can teach multiple classes)
            $classrooms = Classroom::all();
            $teacher->classrooms()->attach($classrooms->pluck('id'));

            $this->command->info("Created teacher: {$teacherData['name']}");
        }
    }

    private function createStudents()
    {
        $students = [
            // 1st Year Students
            ['name' => 'Alice Cooper', 'email' => 'alice.cooper@student.edu', 'year' => '1st Year'],
            ['name' => 'Bob Wilson', 'email' => 'bob.wilson@student.edu', 'year' => '1st Year'],
            ['name' => 'Charlie Brown', 'email' => 'charlie.brown@student.edu', 'year' => '1st Year'],
            ['name' => 'Diana Prince', 'email' => 'diana.prince@student.edu', 'year' => '1st Year'],
            ['name' => 'Edward Norton', 'email' => 'edward.norton@student.edu', 'year' => '1st Year'],

            // 2nd Year Students
            ['name' => 'Fiona Green', 'email' => 'fiona.green@student.edu', 'year' => '2nd Year'],
            ['name' => 'George Lucas', 'email' => 'george.lucas@student.edu', 'year' => '2nd Year'],
            ['name' => 'Helen Troy', 'email' => 'helen.troy@student.edu', 'year' => '2nd Year'],
            ['name' => 'Ian Malcolm', 'email' => 'ian.malcolm@student.edu', 'year' => '2nd Year'],
            ['name' => 'Julia Roberts', 'email' => 'julia.roberts@student.edu', 'year' => '2nd Year'],

            // 3rd Year Students
            ['name' => 'Kevin Hart', 'email' => 'kevin.hart@student.edu', 'year' => '3rd Year'],
            ['name' => 'Laura Palmer', 'email' => 'laura.palmer@student.edu', 'year' => '3rd Year'],
            ['name' => 'Mike Tyson', 'email' => 'mike.tyson@student.edu', 'year' => '3rd Year'],
            ['name' => 'Nina Simone', 'email' => 'nina.simone@student.edu', 'year' => '3rd Year'],
            ['name' => 'Oscar Wilde', 'email' => 'oscar.wilde@student.edu', 'year' => '3rd Year'],
        ];

        foreach ($students as $studentData) {
            $student = User::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'password' => Hash::make('password123'),
                'is_admin' => 0,
                'is_active' => 1,
                'email_verified_at' => now(),
            ]);

            // Assign student role
            $student->assignRole('user');

            // Assign to appropriate classroom based on year
            $classroom = Classroom::where('year', $studentData['year'])
                ->where('semester', 'Semester 1')
                ->first();

            if ($classroom) {
                $student->classrooms()->attach($classroom->id);
            }

            // Assign random sections and certifications
            $sections = Section::inRandomOrder()->limit(rand(1, 3))->get();
            $student->sections()->attach($sections->pluck('id'));

            $certifications = Certification::inRandomOrder()->limit(rand(1, 2))->get();
            $student->certifications()->attach($certifications->pluck('id'));

            $this->command->info("Created student: {$studentData['name']}");
        }
    }

    private function createTests()
    {
        $tests = [
            [
                'name' => 'Information Security Fundamentals',
                'certification_name' => 'CISSP',
                'question_count' => 10,
            ],
            [
                'name' => 'Network Security Basics',
                'certification_name' => 'CCNA',
                'question_count' => 8,
            ],
            [
                'name' => 'Cybersecurity Threats and Defense',
                'certification_name' => 'CISSP',
                'question_count' => 12,
            ],
            [
                'name' => 'Ethical Hacking Principles',
                'certification_name' => 'CEH',
                'question_count' => 15,
            ],
            [
                'name' => 'Risk Management and Compliance',
                'certification_name' => 'CISSP',
                'question_count' => 10,
            ],
        ];

        foreach ($tests as $testData) {
            $certification = Certification::where('name', $testData['certification_name'])->first();

            if ($certification) {
                // Get random questions for this test
                $questions = Question::inRandomOrder()
                    ->limit($testData['question_count'])
                    ->get();

                $test = Test::create([
                    'name' => $testData['name'],
                    'certification_id' => $certification->id,
                    'question_ids' => $questions->pluck('id')->toArray(),
                    'is_active' => true,
                ]);

                // Attach questions to test
                $test->questions()->attach($questions->pluck('id'));

                $this->command->info("Created test: {$testData['name']} with {$testData['question_count']} questions");
            }
        }
    }

    private function createHomework()
    {
        $homeworkAssignments = [
            [
                'title' => 'Security Policy Analysis',
                'description' => 'Analyze the company security policy and identify potential improvements. Submit a 2-page report.',
                'instructions' => '1. Read the provided security policy document\n2. Identify strengths and weaknesses\n3. Suggest 3 specific improvements\n4. Submit as PDF document',
                'max_points' => 100,
                'due_days' => 7,
                'attachments' => ['security_policy_template.pdf', 'sample_analysis.pdf'],
            ],
            [
                'title' => 'Network Vulnerability Assessment',
                'description' => 'Perform a vulnerability assessment on the given network diagram and identify potential security risks.',
                'instructions' => '1. Review the network diagram\n2. Identify vulnerable components\n3. Classify risks by severity\n4. Propose mitigation strategies',
                'max_points' => 150,
                'due_days' => 10,
                'attachments' => ['network_diagram.pdf', 'vulnerability_checklist.pdf'],
            ],
            [
                'title' => 'Incident Response Plan',
                'description' => 'Create an incident response plan for a small business scenario.',
                'instructions' => '1. Define incident types\n2. Create response procedures\n3. Assign responsibilities\n4. Include communication plan',
                'max_points' => 120,
                'due_days' => 14,
                'attachments' => ['incident_response_template.docx'],
            ],
            [
                'title' => 'Cryptography Implementation',
                'description' => 'Implement basic encryption/decryption algorithms and demonstrate their usage.',
                'instructions' => '1. Choose an encryption algorithm\n2. Implement encryption function\n3. Implement decryption function\n4. Demonstrate with sample data',
                'max_points' => 200,
                'due_days' => 21,
                'attachments' => ['crypto_examples.pdf', 'sample_code.zip'],
            ],
            [
                'title' => 'Security Audit Report',
                'description' => 'Conduct a security audit of the classroom network and prepare a comprehensive report.',
                'instructions' => '1. Scan for vulnerabilities\n2. Test access controls\n3. Review configurations\n4. Prepare findings report',
                'max_points' => 180,
                'due_days' => 18,
                'attachments' => ['audit_checklist.pdf', 'reporting_template.docx'],
            ],
        ];

        $teachers = User::where('is_admin', 1)->get();
        $classrooms = Classroom::all();
        $sections = Section::all();
        $certifications = Certification::all();

        foreach ($homeworkAssignments as $hwData) {
            $teacher = $teachers->random();
            $classroom = $classrooms->random();
            $section = $sections->random();
            $certification = $certifications->random();

            Homework::create([
                'title' => $hwData['title'],
                'description' => $hwData['description'],
                'instructions' => $hwData['instructions'],
                'teacher_id' => $teacher->id,
                'classroom_id' => $classroom->id,
                'section_id' => $section->id,
                'certification_id' => $certification->id,
                'assigned_date' => now()->subDays(rand(1, 30)),
                'due_date' => now()->addDays($hwData['due_days']),
                'max_points' => $hwData['max_points'],
                'attachments' => $hwData['attachments'],
                'allow_late_submission' => (bool) rand(0, 1),
                'is_published' => true,
            ]);

            $this->command->info("Created homework: {$hwData['title']}");
        }
    }

    private function createHomeworkSubmissions()
    {
        $homework = Homework::all();
        $students = User::where('is_admin', 0)->get();

        foreach ($homework as $hw) {
            // Get students in the same classroom as the homework
            $classroomStudents = $students->filter(function ($student) use ($hw) {
                return $student->classrooms()->where('classroom_id', $hw->classroom_id)->exists();
            });

            // Create submissions for 60-80% of students
            $submittingStudents = $classroomStudents->random(
                (int) ($classroomStudents->count() * (0.6 + rand(0, 20) / 100))
            );

            foreach ($submittingStudents as $student) {
                $submittedAt = $this->getRandomSubmissionTime($hw);
                $isLate = $submittedAt > $hw->due_date;
                $status = $this->getRandomSubmissionStatus();

                HomeworkSubmission::create([
                    'homework_id' => $hw->id,
                    'student_id' => $student->id,
                    'submission_text' => $this->getRandomSubmissionText($hw->title),
                'submitted_files' => $this->getRandomAttachments(),
                    'submitted_at' => $submittedAt,
                    'status' => $status,
                    'score' => $status === 'graded' ? rand(60, 100) : null,
                    'teacher_feedback' => $status === 'graded' ? $this->getRandomFeedback() : null,
                    'graded_by' => $status === 'graded' ? $hw->teacher_id : null,
                    'graded_at' => $status === 'graded' ? $submittedAt->addDays(rand(1, 3)) : null,
                ]);
            }

            $this->command->info("Created submissions for homework: {$hw->title}");
        }
    }

    private function createQuizAttempts()
    {
        $tests = Test::all();
        $students = User::where('is_admin', 0)->get();

        foreach ($tests as $test) {
            // 70-90% of students attempt each test
            $attemptingStudents = $students->random(
                (int) ($students->count() * (0.7 + rand(0, 20) / 100))
            );

            foreach ($attemptingStudents as $student) {
                $startedAt = now()->subDays(rand(1, 30));
                $completed = (bool) rand(0, 1);

                $quizHeader = QuizHeader::create([
                    'user_id' => $student->id,
                    'test_id' => $test->id,
                    'section_id' => $student->sections()->first()?->id,
                    'certification_id' => $test->certification_id,
                    'domains' => ['security', 'networking', 'compliance'],
                    'completed' => $completed,
                    'quiz_size' => $test->questions()->count(),
                    'questions_taken' => $test->question_ids,
                    'score' => $completed ? rand(60, 100) : 0,
                    'difficulty' => ['easy', 'medium', 'hard'],
                    'learningmode' => false,
                    'current_index' => $completed ? $test->questions()->count() : rand(1, $test->questions()->count()),
                    'started_at' => $startedAt,
                    'finished_at' => $completed ? $startedAt->addMinutes(rand(20, 60)) : null,
                ]);

                // Create quiz answers if completed
                if ($completed) {
                    $this->createQuizAnswers($quizHeader);
                }

                $this->command->info("Created quiz attempt for student: {$student->name} on test: {$test->name}");
            }
        }
    }

    private function createQuizAnswers(QuizHeader $quizHeader)
    {
        $questions = $quizHeader->test->questions;

        foreach ($questions as $question) {
            $answers = $question->answers;
            $correctAnswer = $answers->where('is_checked', 1)->first();
            $selectedAnswer = rand(0, 1) ? $correctAnswer : $answers->random();

            QuizAnswer::create([
                'user_id' => $quizHeader->user_id,
                'quiz_header_id' => $quizHeader->id,
                'question_id' => $question->id,
                'answer_id' => $selectedAnswer->id,
                'is_correct' => $selectedAnswer->id === $correctAnswer->id,
            ]);
        }
    }

    private function createStudyMaterials()
    {
        $materials = [
            [
                'title' => 'Introduction to Information Security',
                'content' => 'Comprehensive guide covering the fundamentals of information security, including CIA triad, security principles, and basic concepts.',
                'file_path' => 'study_materials/info_sec_basics.pdf',
                'type' => 'document',
            ],
            [
                'title' => 'Network Security Fundamentals',
                'content' => 'Learn about network security concepts, firewalls, VPNs, and common network threats and defenses.',
                'file_path' => 'study_materials/network_security.pdf',
                'type' => 'document',
            ],
            [
                'title' => 'Cryptography Explained',
                'content' => 'Understanding encryption algorithms, public-key cryptography, digital signatures, and cryptographic protocols.',
                'file_path' => 'study_materials/cryptography_guide.pdf',
                'type' => 'document',
            ],
            [
                'title' => 'Cybersecurity Best Practices',
                'content' => 'Essential security practices for individuals and organizations, including password management and secure coding.',
                'file_path' => 'study_materials/security_best_practices.pdf',
                'type' => 'document',
            ],
            [
                'title' => 'Ethical Hacking Tutorial',
                'content' => 'Introduction to ethical hacking methodologies, tools, and techniques for security testing.',
                'file_path' => 'study_materials/ethical_hacking.mp4',
                'type' => 'video',
            ],
            [
                'title' => 'Security Policy Templates',
                'content' => 'Collection of security policy templates for various organizational needs and compliance requirements.',
                'file_path' => 'study_materials/policy_templates.zip',
                'type' => 'archive',
            ],
            [
                'title' => 'Risk Assessment Framework',
                'content' => 'Step-by-step guide to conducting security risk assessments and implementing risk mitigation strategies.',
                'file_path' => 'study_materials/risk_assessment.pdf',
                'type' => 'document',
            ],
            [
                'title' => 'Incident Response Procedures',
                'content' => 'Detailed procedures for handling security incidents, from detection to recovery and lessons learned.',
                'file_path' => 'study_materials/incident_response.pdf',
                'type' => 'document',
            ],
        ];

        $teachers = User::where('is_admin', 1)->get();

        foreach ($materials as $material) {
            $teacher = $teachers->random();
            $certification = Certification::inRandomOrder()->first();
            $section = Section::inRandomOrder()->first();

            $hub = Hub::create([
                'title' => $material['title'],
                'description' => $material['content'],
                'type' => $material['type'],
                'file_path' => [$material['file_path']],
                'certification_id' => $certification->id,
                'section_id' => $section->id,
            ]);

            // Attach the teacher to the hub via the pivot table
            $hub->users()->attach($teacher->id);

            $this->command->info("Created study material: {$material['title']}");
        }
    }

    // Helper methods
    private function getRandomSubmissionTime(Homework $homework): Carbon
    {
        $assignedDate = Carbon::parse($homework->assigned_date);
        $dueDate = Carbon::parse($homework->due_date);

        // Submissions can be from assignment date to due date + some late submissions
        $maxDate = $homework->allow_late_submission
            ? $dueDate->addDays(rand(1, 7))
            : $dueDate;

        return $assignedDate->addDays(rand(0, $assignedDate->diffInDays($maxDate)));
    }

    private function getRandomSubmissionStatus(): string
    {
        $statuses = ['not_submitted', 'submitted', 'graded'];
        $weights = [10, 30, 60]; // 10% not submitted, 30% submitted, 60% graded

        $rand = rand(1, 100);
        $cumulative = 0;

        foreach ($statuses as $index => $status) {
            $cumulative += $weights[$index];
            if ($rand <= $cumulative) {
                return $status;
            }
        }

        return 'submitted';
    }

    private function getRandomSubmissionText(string $homeworkTitle): string
    {
        $templates = [
            "Completed the {$homeworkTitle} assignment. Please find my analysis attached.",
            "Here is my submission for {$homeworkTitle}. I have followed all the requirements in the instructions.",
            "Submitted {$homeworkTitle} work. The attached document contains my findings and recommendations.",
            "My {$homeworkTitle} assignment is ready for review. I've included all requested sections.",
            "Please review my {$homeworkTitle} submission. I believe it meets all the criteria specified.",
        ];

        return $templates[array_rand($templates)];
    }

    private function getRandomAttachments(): array
    {
        $fileTypes = ['pdf', 'docx', 'xlsx', 'pptx'];
        $count = rand(1, 3);

        $attachments = [];
        for ($i = 0; $i < $count; $i++) {
            $type = $fileTypes[array_rand($fileTypes)];
            $attachments[] = "submission_" . ($i + 1) . ".{$type}";
        }

        return $attachments;
    }

    private function getRandomFeedback(): string
    {
        $feedbacks = [
            "Excellent work! You demonstrated a strong understanding of the concepts.",
            "Good analysis with some valuable insights. Consider expanding on the recommendations.",
            "Well-structured submission. The implementation shows good technical skills.",
            "Solid work overall. Pay more attention to detail in the next assignment.",
            "Creative approach to the problem. The solution is practical and well-thought-out.",
            "Good effort. Focus on improving the documentation quality for future assignments.",
            "Comprehensive analysis with good research. The conclusions are well-supported.",
        ];

        return $feedbacks[array_rand($feedbacks)];
    }
}
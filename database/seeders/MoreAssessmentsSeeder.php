<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\QuestionOption;
use App\Models\User;
use App\Models\Section;
use App\Models\Classroom;

class MoreAssessmentsSeeder extends Seeder
{
    public function run(): void
    {
        // Get a teacher user
        $teacher = User::whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->first();

        if (!$teacher) {
            $teacher = User::first();
        }

        // Get some sections and classrooms
        $section = Section::first();
        $classroom = Classroom::first();

        $assessmentsData = [
            [
                'title' => 'Web Development Fundamentals',
                'description' => 'Test your knowledge of HTML, CSS, and JavaScript basics',
                'category' => 'Web Development',
                'difficulty' => 'easy',
                'time_limit' => 45,
                'passing_score' => 70,
                'questions' => [
                    [
                        'question' => 'What does HTML stand for?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'Hyper Text Markup Language', 'is_correct' => true],
                            ['text' => 'High Tech Modern Language', 'is_correct' => false],
                            ['text' => 'Home Tool Markup Language', 'is_correct' => false],
                            ['text' => 'Hyperlinks and Text Markup Language', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'Which CSS property is used to change text color?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'color', 'is_correct' => true],
                            ['text' => 'text-color', 'is_correct' => false],
                            ['text' => 'font-color', 'is_correct' => false],
                            ['text' => 'text-style', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What is the correct syntax for referring to an external JavaScript file?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => '<script src="app.js"></script>', 'is_correct' => true],
                            ['text' => '<script href="app.js"></script>', 'is_correct' => false],
                            ['text' => '<script name="app.js"></script>', 'is_correct' => false],
                            ['text' => '<js src="app.js"></js>', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'Which HTML tag is used to define an internal style sheet?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => '<style>', 'is_correct' => true],
                            ['text' => '<css>', 'is_correct' => false],
                            ['text' => '<script>', 'is_correct' => false],
                            ['text' => '<stylesheet>', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What is the correct way to declare a JavaScript variable?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'let myVar = 5;', 'is_correct' => true],
                            ['text' => 'variable myVar = 5;', 'is_correct' => false],
                            ['text' => 'v myVar = 5;', 'is_correct' => false],
                            ['text' => 'var: myVar = 5;', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Database Design and SQL',
                'description' => 'Assessment on database concepts, normalization, and SQL queries',
                'category' => 'Database',
                'difficulty' => 'medium',
                'time_limit' => 60,
                'passing_score' => 75,
                'questions' => [
                    [
                        'question' => 'What does SQL stand for?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'Structured Query Language', 'is_correct' => true],
                            ['text' => 'Simple Query Language', 'is_correct' => false],
                            ['text' => 'Standard Question Language', 'is_correct' => false],
                            ['text' => 'System Query Language', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'Which SQL command is used to retrieve data from a database?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'SELECT', 'is_correct' => true],
                            ['text' => 'GET', 'is_correct' => false],
                            ['text' => 'RETRIEVE', 'is_correct' => false],
                            ['text' => 'FETCH', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What is a primary key in a database?',
                        'type' => 'multiple_choice',
                        'points' => 3,
                        'options' => [
                            ['text' => 'A unique identifier for each record in a table', 'is_correct' => true],
                            ['text' => 'The first column in a table', 'is_correct' => false],
                            ['text' => 'A password to access the database', 'is_correct' => false],
                            ['text' => 'The main table in a database', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What does the SQL JOIN clause do?',
                        'type' => 'multiple_choice',
                        'points' => 3,
                        'options' => [
                            ['text' => 'Combines rows from two or more tables based on a related column', 'is_correct' => true],
                            ['text' => 'Merges two databases together', 'is_correct' => false],
                            ['text' => 'Adds new columns to a table', 'is_correct' => false],
                            ['text' => 'Connects to a database server', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'Which normal form eliminates redundant data?',
                        'type' => 'multiple_choice',
                        'points' => 3,
                        'options' => [
                            ['text' => 'Third Normal Form (3NF)', 'is_correct' => true],
                            ['text' => 'First Normal Form (1NF)', 'is_correct' => false],
                            ['text' => 'Second Normal Form (2NF)', 'is_correct' => false],
                            ['text' => 'Fourth Normal Form (4NF)', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Python Programming Basics',
                'description' => 'Introduction to Python syntax, data types, and control structures',
                'category' => 'Programming',
                'difficulty' => 'easy',
                'time_limit' => 40,
                'passing_score' => 70,
                'questions' => [
                    [
                        'question' => 'Which keyword is used to define a function in Python?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'def', 'is_correct' => true],
                            ['text' => 'function', 'is_correct' => false],
                            ['text' => 'func', 'is_correct' => false],
                            ['text' => 'define', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What is the output of: print(type([]))',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => '<class \'list\'>', 'is_correct' => true],
                            ['text' => '<class \'array\'>', 'is_correct' => false],
                            ['text' => '<class \'dict\'>', 'is_correct' => false],
                            ['text' => '<class \'tuple\'>', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'How do you start a comment in Python?',
                        'type' => 'multiple_choice',
                        'points' => 1,
                        'options' => [
                            ['text' => '#', 'is_correct' => true],
                            ['text' => '//', 'is_correct' => false],
                            ['text' => '/*', 'is_correct' => false],
                            ['text' => '--', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'Which data type is immutable in Python?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'tuple', 'is_correct' => true],
                            ['text' => 'list', 'is_correct' => false],
                            ['text' => 'dictionary', 'is_correct' => false],
                            ['text' => 'set', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What does the len() function do?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'Returns the number of items in an object', 'is_correct' => true],
                            ['text' => 'Returns the length of a string in bytes', 'is_correct' => false],
                            ['text' => 'Calculates the length of a number', 'is_correct' => false],
                            ['text' => 'Measures the execution time', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'How do you create a dictionary in Python?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => '{}', 'is_correct' => true],
                            ['text' => '[]', 'is_correct' => false],
                            ['text' => '()', 'is_correct' => false],
                            ['text' => '<>', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Java Object-Oriented Programming',
                'description' => 'Test on OOP concepts in Java including inheritance, polymorphism, and encapsulation',
                'category' => 'Programming',
                'difficulty' => 'medium',
                'time_limit' => 50,
                'passing_score' => 75,
                'questions' => [
                    [
                        'question' => 'What is encapsulation in Java?',
                        'type' => 'multiple_choice',
                        'points' => 3,
                        'options' => [
                            ['text' => 'Hiding internal state and requiring all interaction through methods', 'is_correct' => true],
                            ['text' => 'Creating multiple methods with the same name', 'is_correct' => false],
                            ['text' => 'Inheriting properties from a parent class', 'is_correct' => false],
                            ['text' => 'Converting one data type to another', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'Which keyword is used to inherit a class in Java?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'extends', 'is_correct' => true],
                            ['text' => 'inherits', 'is_correct' => false],
                            ['text' => 'implements', 'is_correct' => false],
                            ['text' => 'super', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What is polymorphism?',
                        'type' => 'multiple_choice',
                        'points' => 3,
                        'options' => [
                            ['text' => 'The ability of an object to take many forms', 'is_correct' => true],
                            ['text' => 'Creating multiple instances of a class', 'is_correct' => false],
                            ['text' => 'Hiding implementation details', 'is_correct' => false],
                            ['text' => 'Using multiple inheritance', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What is the purpose of the "static" keyword in Java?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'To create class-level members that belong to the class itself', 'is_correct' => true],
                            ['text' => 'To prevent a variable from changing', 'is_correct' => false],
                            ['text' => 'To make a method abstract', 'is_correct' => false],
                            ['text' => 'To enable inheritance', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What is an interface in Java?',
                        'type' => 'multiple_choice',
                        'points' => 3,
                        'options' => [
                            ['text' => 'A reference type that contains only abstract methods and constants', 'is_correct' => true],
                            ['text' => 'A class that cannot be instantiated', 'is_correct' => false],
                            ['text' => 'A method with no body', 'is_correct' => false],
                            ['text' => 'A graphical user interface', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Cloud Computing Essentials',
                'description' => 'Understanding cloud services, deployment models, and cloud platforms',
                'category' => 'Cloud Computing',
                'difficulty' => 'medium',
                'time_limit' => 45,
                'passing_score' => 70,
                'questions' => [
                    [
                        'question' => 'What does IaaS stand for?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'Infrastructure as a Service', 'is_correct' => true],
                            ['text' => 'Internet as a Service', 'is_correct' => false],
                            ['text' => 'Integration as a Service', 'is_correct' => false],
                            ['text' => 'Information as a Service', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'Which cloud deployment model is accessible to the general public?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'Public Cloud', 'is_correct' => true],
                            ['text' => 'Private Cloud', 'is_correct' => false],
                            ['text' => 'Hybrid Cloud', 'is_correct' => false],
                            ['text' => 'Community Cloud', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What is the main advantage of cloud computing?',
                        'type' => 'multiple_choice',
                        'points' => 3,
                        'options' => [
                            ['text' => 'Scalability and flexibility', 'is_correct' => true],
                            ['text' => 'Complete control over hardware', 'is_correct' => false],
                            ['text' => 'No internet connection required', 'is_correct' => false],
                            ['text' => 'Free unlimited storage', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'Which is an example of PaaS (Platform as a Service)?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'Google App Engine', 'is_correct' => true],
                            ['text' => 'Amazon EC2', 'is_correct' => false],
                            ['text' => 'Dropbox', 'is_correct' => false],
                            ['text' => 'Microsoft Office 365', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What is virtualization in cloud computing?',
                        'type' => 'multiple_choice',
                        'points' => 3,
                        'options' => [
                            ['text' => 'Creating virtual versions of physical resources', 'is_correct' => true],
                            ['text' => 'Securing data with encryption', 'is_correct' => false],
                            ['text' => 'Backing up data automatically', 'is_correct' => false],
                            ['text' => 'Connecting multiple clouds together', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'Fundamentals of iOS and Android app development',
                'category' => 'Mobile Development',
                'difficulty' => 'easy',
                'time_limit' => 40,
                'passing_score' => 70,
                'questions' => [
                    [
                        'question' => 'Which programming language is primarily used for Android development?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'Kotlin', 'is_correct' => true],
                            ['text' => 'Swift', 'is_correct' => false],
                            ['text' => 'C#', 'is_correct' => false],
                            ['text' => 'Ruby', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What is the official IDE for Android development?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'Android Studio', 'is_correct' => true],
                            ['text' => 'Visual Studio', 'is_correct' => false],
                            ['text' => 'Xcode', 'is_correct' => false],
                            ['text' => 'Eclipse', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'Which language is used for iOS app development?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'Swift', 'is_correct' => true],
                            ['text' => 'Java', 'is_correct' => false],
                            ['text' => 'Python', 'is_correct' => false],
                            ['text' => 'JavaScript', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What is React Native?',
                        'type' => 'multiple_choice',
                        'points' => 3,
                        'options' => [
                            ['text' => 'A framework for building cross-platform mobile apps', 'is_correct' => true],
                            ['text' => 'An Android testing tool', 'is_correct' => false],
                            ['text' => 'An iOS simulator', 'is_correct' => false],
                            ['text' => 'A database for mobile apps', 'is_correct' => false],
                        ]
                    ],
                    [
                        'question' => 'What does API stand for in mobile development?',
                        'type' => 'multiple_choice',
                        'points' => 2,
                        'options' => [
                            ['text' => 'Application Programming Interface', 'is_correct' => true],
                            ['text' => 'Android Programming Interface', 'is_correct' => false],
                            ['text' => 'App Process Integration', 'is_correct' => false],
                            ['text' => 'Advanced Programming Implementation', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
        ];

        foreach ($assessmentsData as $assessmentData) {
            // Create assessment
            $assessment = Assessment::create([
                'title' => $assessmentData['title'],
                'description' => $assessmentData['description'],
                'type' => 'quiz',
                'category' => $assessmentData['category'],
                'difficulty' => $assessmentData['difficulty'],
                'time_limit' => $assessmentData['time_limit'],
                'passing_score' => $assessmentData['passing_score'],
                'attempts_allowed' => 3,
                'shuffle_questions' => true,
                'shuffle_options' => true,
                'show_correct_answers' => true,
                'teacher_id' => $teacher->id,
                'classroom_id' => $classroom?->id,
                'section_id' => $section?->id,
                'is_published' => true,
                'is_active' => true,
            ]);

            // Create questions for this assessment
            $order = 1;
            foreach ($assessmentData['questions'] as $questionData) {
                $question = AssessmentQuestion::create([
                    'assessment_id' => $assessment->id,
                    'question_text' => $questionData['question'],
                    'question_type' => $questionData['type'],
                    'points' => $questionData['points'],
                    'order' => $order++,
                ]);

                // Create options for this question
                $optionOrder = 1;
                foreach ($questionData['options'] as $optionData) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $optionData['text'],
                        'is_correct' => $optionData['is_correct'],
                        'order' => $optionOrder++,
                    ]);
                }
            }

            $this->command->info("Created assessment: {$assessment->title} with " . count($assessmentData['questions']) . " questions");
        }

        $this->command->info('✓ Successfully created ' . count($assessmentsData) . ' new assessments!');
    }
}

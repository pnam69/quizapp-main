<?php

namespace Database\Seeders;

use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MigrateTestsToAssessmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        
        try {
            $tests = Test::with('certification')->get();
            $this->command->info("Found {$tests->count()} tests to migrate...");

            foreach ($tests as $test) {
                $this->command->info("Migrating: {$test->name}");

                // Create assessment from test
                $assessment = Assessment::create([
                    'title' => $test->name,
                    'description' => "Migrated from old test system",
                    'teacher_id' => 1, // Default to first user (admin)
                    'certification_id' => $test->certification_id,
                    'type' => 'test',
                    'is_published' => $test->is_active ? true : false,
                    'is_active' => $test->is_active ? true : false,
                    'passing_score' => 70, // Default passing score
                    'shuffle_questions' => false,
                    'shuffle_options' => false,
                    'show_correct_answers' => true,
                ]);

                // Get question IDs
                $questionIds = $test->question_ids;
                if (is_string($questionIds)) {
                    $questionIds = json_decode($questionIds, true);
                }
                if (!is_array($questionIds)) {
                    $questionIds = [];
                }

                // Migrate questions
                $order = 1;
                foreach ($questionIds as $questionId) {
                    $oldQuestion = Question::with('answers')->find($questionId);
                    
                    if (!$oldQuestion) {
                        continue;
                    }

                    // Create assessment question
                    $assessmentQuestion = AssessmentQuestion::create([
                        'assessment_id' => $assessment->id,
                        'question_text' => $oldQuestion->question,
                        'question_type' => 'multiple_choice',
                        'points' => 1, // Default 1 point per question
                        'order' => $order++,
                    ]);

                    // Migrate answer options
                    $optionOrder = 1;
                    foreach ($oldQuestion->answers as $answer) {
                        QuestionOption::create([
                            'question_id' => $assessmentQuestion->id,
                            'option_text' => $answer->answer,
                            'is_correct' => (bool) $answer->is_checked,
                            'order' => $optionOrder++,
                        ]);
                    }

                    $this->command->info("  - Migrated question: {$oldQuestion->question}");
                }

                $this->command->info("✓ Successfully migrated: {$test->name} ({$assessment->questions->count()} questions)");
            }

            DB::commit();
            $this->command->info("\n✅ Migration completed successfully!");
            $this->command->info("Total assessments created: " . Assessment::count());
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("❌ Migration failed: " . $e->getMessage());
            Log::error("Test migration failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}

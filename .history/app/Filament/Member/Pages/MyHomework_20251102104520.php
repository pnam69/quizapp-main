<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use App\Models\Homework;
use App\Models\HomeworkSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class MyHomework extends Page implements HasForms
{
    use InteractsWithForms;
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'My Homework';
    protected static ?int $navigationSort = 3;
    protected static string $view = 'filament.member.pages.my-homework';

    public ?array $data = [];
    public $selectedHomework = null;
    public $showSubmissionForm = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('submission_text')
                    ->label('Your Answer')
                    ->required()
                    ->rows(6)
                    ->maxLength(5000)
                    ->placeholder('Type your answer here...'),

                Forms\Components\FileUpload::make('submitted_files')
                    ->label('Upload Files (Optional)')
                    ->multiple()
                    ->disk('public')
                    ->directory('homework_submissions')
                    ->preserveFilenames(false) // Security: prevent filename conflicts
                    ->maxSize(10240) // 10MB per file
                    ->maxFiles(5) // Maximum 5 files
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'image/jpeg',
                        'image/png',
                        'text/plain',
                    ])
                    ->helperText('Allowed: PDF, Word, Excel, Images, Text (Max 5 files, 10MB each)'),
            ])
            ->statePath('data');
    }

    public function getHomework()
    {
        $studentId = Auth::id();

        return Homework::where('is_published', true)
            ->with(['certification', 'section', 'classroom', 'submissions' => function ($query) use ($studentId) {
                $query->where('student_id', $studentId);
            }])
            ->where(function ($query) use ($studentId) {
                // Get homework assigned to student's classroom or all students
                $query->whereIn('classroom_id', Auth::user()->classrooms->pluck('id'))
                    ->orWhereNull('classroom_id');
            })
            ->orderBy('due_date', 'asc')
            ->get();
    }

    public function getPendingHomework()
    {
        return $this->getHomework()->filter(function ($homework) {
            $submission = $homework->submissions->first();
            return !$submission || $submission->status === 'not_submitted';
        });
    }

    public function getSubmittedHomework()
    {
        return $this->getHomework()->filter(function ($homework) {
            $submission = $homework->submissions->first();
            return $submission && $submission->status !== 'not_submitted';
        });
    }

    public function viewHomework($homeworkId)
    {
        $this->selectedHomework = Homework::with(['submissions' => function ($query) {
            $query->where('student_id', Auth::id());
        }])->find($homeworkId);

        $this->showSubmissionForm = true;
    }

    public function closeForm()
    {
        $this->showSubmissionForm = false;
        $this->selectedHomework = null;
        $this->form->fill();
    }

    public function submitHomework()
    {
        // Rate limiting: Prevent spam submissions (max 10 per hour)
        $userId = Auth::id();
        $cacheKey = "homework_submission_rate_limit_{$userId}";
        $attempts = cache()->get($cacheKey, 0);
        
        if ($attempts >= 10) {
            Notification::make()
                ->title('Too Many Submissions')
                ->body('Please wait before submitting again. Maximum 10 submissions per hour.')
                ->danger()
                ->send();
            return;
        }
        
        $data = $this->form->getState();

        if (!$this->selectedHomework) {
            return;
        }

        // Check if already submitted and graded
        $existingSubmission = HomeworkSubmission::where('homework_id', $this->selectedHomework->id)
            ->where('student_id', $userId)
            ->first();
            
        if ($existingSubmission && $existingSubmission->status === 'graded') {
            Notification::make()
                ->title('Already Graded')
                ->body('This homework has already been graded. You cannot resubmit.')
                ->warning()
                ->send();
            return;
        }

        $submission = HomeworkSubmission::firstOrNew([
            'homework_id' => $this->selectedHomework->id,
            'student_id' => $userId,
        ]);

        $isLate = now()->gt($this->selectedHomework->due_date);

        $submission->fill([
            'submission_text' => strip_tags($data['submission_text'], '<p><br><strong><em><u>'), // Sanitize HTML
            'submitted_files' => $data['submitted_files'] ?? null,
            'submitted_at' => now(),
            'status' => $isLate ? 'late' : 'submitted',
        ]);

        $submission->save();

        // Increment rate limit counter (expires in 1 hour)
        cache()->put($cacheKey, $attempts + 1, now()->addHour());

        Notification::make()
            ->title('Homework Submitted!')
            ->body('Your homework has been submitted successfully.')
            ->success()
            ->send();

        $this->closeForm();
    }

    protected function getForms(): array
    {
        return [
            'form',
        ];
    }
}

<?php

namespace App\Policies;

use App\Models\HomeworkSubmission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HomeworkSubmissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Teachers and admins can view all submissions
        return $user->is_admin || $user->hasRole('teacher');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, HomeworkSubmission $submission): bool
    {
        // Students can view their own submissions
        // Teachers can view submissions for their homework
        // Admins can view all
        if ($user->is_admin) {
            return true;
        }

        if ($submission->student_id === $user->id) {
            return true;
        }

        return $submission->homework->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // All authenticated users (students) can create submissions
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, HomeworkSubmission $submission): bool
    {
        // Students can update their own ungraded submissions
        // Teachers and admins cannot update submissions (they grade them instead)
        if ($submission->status === 'graded') {
            return false;
        }

        return $submission->student_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HomeworkSubmission $submission): bool
    {
        // Students can delete their own ungraded submissions
        // Admins can delete any submission
        if ($user->is_admin) {
            return true;
        }

        if ($submission->status === 'graded') {
            return false;
        }

        return $submission->student_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, HomeworkSubmission $submission): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, HomeworkSubmission $submission): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can grade the submission.
     */
    public function grade(User $user, HomeworkSubmission $submission): bool
    {
        // Only the teacher who created the homework or admins can grade
        if ($user->is_admin) {
            return true;
        }

        return $submission->homework->teacher_id === $user->id;
    }
}

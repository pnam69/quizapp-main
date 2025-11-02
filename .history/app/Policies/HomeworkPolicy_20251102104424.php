<?php

namespace App\Policies;

use App\Models\Homework;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HomeworkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Only teachers/admins can view homework list in admin panel
        return $user->is_admin || $user->hasRole('teacher');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Homework $homework): bool
    {
        // Teachers can view their own homework or admins can view all
        if ($user->is_admin) {
            return true;
        }

        return $homework->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only teachers and admins can create homework
        return $user->is_admin || $user->hasRole('teacher');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Homework $homework): bool
    {
        // Teachers can only update their own homework, admins can update all
        if ($user->is_admin) {
            return true;
        }

        return $homework->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Homework $homework): bool
    {
        // Teachers can only delete their own homework, admins can delete all
        if ($user->is_admin) {
            return true;
        }

        return $homework->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Homework $homework): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Homework $homework): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can grade submissions.
     */
    public function gradeSubmissions(User $user, Homework $homework): bool
    {
        // Teachers can grade their own homework submissions, admins can grade all
        if ($user->is_admin) {
            return true;
        }

        return $homework->teacher_id === $user->id;
    }
}

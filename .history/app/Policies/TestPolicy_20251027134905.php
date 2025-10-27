<?php

namespace App\Policies;

use App\Models\Test;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Test $test): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Test $test): bool
    {
        return true;
    }

    public function delete(User $user, Test $test): bool
    {
        return true;
    }

    public function deleteAny(User $user): bool
    {
        return true;
    }
}

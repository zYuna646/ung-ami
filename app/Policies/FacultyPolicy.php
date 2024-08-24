<?php

namespace App\Policies;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FacultyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Faculty $faculty): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Faculty $faculty): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Faculty $faculty): bool
    {
        return $user->isAdmin() && $faculty->is_deletable;
    }

    public function restore(User $user, Faculty $faculty): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Faculty $faculty): bool
    {
        return $user->isAdmin();
    }
}

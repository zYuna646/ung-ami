<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DepartmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Department $department): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Department $department): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Department $department): bool
    {
        return $user->isAdmin() && $department->is_deletable;
    }

    public function restore(User $user, Department $department): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Department $department): bool
    {
        return $user->isAdmin() && $department->is_deletable;
    }
}

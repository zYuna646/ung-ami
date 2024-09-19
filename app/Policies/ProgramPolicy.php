<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProgramPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Program $program): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Program $program): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Program $program): bool
    {
        return $user->isAdmin() && $program->is_deletable;
    }

    public function restore(User $user, Program $program): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Program $program): bool
    {
        return $user->isAdmin() && $program->is_deletable;
    }

    public function viewAnyReport(User $user): bool
    {
        return $user->isAuditor() || $user->isProgram();
    }
}

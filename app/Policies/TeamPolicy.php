<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeamPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Team $team): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Team $team): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Team $team): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Team $team): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Team $team): bool
    {
        return $user->isAdmin();
    }
}

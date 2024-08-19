<?php

namespace App\Policies;

use App\Models\Standard;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StandardPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Standard $standard): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Standard $standard): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Standard $standard): bool
    {
        return $user->isAdmin() && $standard->periodes->isEmpty();
    }

    public function restore(User $user, Standard $standard): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Standard $standard): bool
    {
        return $user->isAdmin();
    }
}

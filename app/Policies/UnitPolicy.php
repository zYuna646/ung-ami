<?php

namespace App\Policies;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UnitPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Unit $unit): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Unit $unit): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Unit $unit): bool
    {
        return $user->isAdmin() && $unit->is_deletable;
    }

    public function restore(User $user, Unit $unit): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Unit $unit): bool
    {
        return $user->isAdmin();
    }
}

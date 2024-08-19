<?php

namespace App\Policies;

use App\Models\Auditor;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AuditorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Auditor $auditor): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Auditor $auditor): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Auditor $auditor): bool
    {
        return $user->isAdmin() && $auditor->chief_periodes->isEmpty();
    }

    public function restore(User $user, Auditor $auditor): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Auditor $auditor): bool
    {
        return $user->isAdmin();
    }
}

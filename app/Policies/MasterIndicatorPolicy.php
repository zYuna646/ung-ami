<?php

namespace App\Policies;

use App\Models\MasterIndicator;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MasterIndicatorPolicy
{
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, MasterIndicator $masterIndicator): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, MasterIndicator $masterIndicator): bool
    {
        return $user->isAdmin();
    }
}

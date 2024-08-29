<?php

namespace App\Policies;

use App\Models\MasterQuestion;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MasterQuestionPolicy
{
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, MasterQuestion $masterQuestion): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, MasterQuestion $masterQuestion): bool
    {
        return $user->isAdmin();
    }
}

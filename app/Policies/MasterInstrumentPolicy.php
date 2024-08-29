<?php

namespace App\Policies;

use App\Models\MasterInstrument;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MasterInstrumentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, MasterInstrument $masterInstrument): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }
    
    public function update(User $user, MasterInstrument $masterInstrument): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, MasterInstrument $masterInstrument): bool
    {
        return $user->isAdmin();
    }
}

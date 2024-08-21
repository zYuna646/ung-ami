<?php

namespace App\Policies;

use App\Models\Instrument;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InstrumentPolicy
{
    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Instrument $instrument): bool
    {
        $hasUserInUnits = $instrument->periode->units->contains(function ($unit) {
            return $unit->user && $unit->user->id === auth()->user()->id;
        });

        return $hasUserInUnits;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Instrument $instrument): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Instrument $instrument): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Instrument $instrument): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Instrument $instrument): bool
    {
        //
    }

    public function viewAnySurvey(User $user): bool
    {
        return $user->isUnit() || $user->isFaculty() || $user->isDepartment() || $user->isProgram();
    }

    public function viewSurvey(User $user, Instrument $instrument): bool
    {
        return $user->isUnit() || $user->isFaculty() || $user->isDepartment() || $user->isProgram();
    }
}

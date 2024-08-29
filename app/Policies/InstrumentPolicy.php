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
        return $instrument->units->contains(function ($unit) use ($user) {
            $userInUnit = $unit->user && $unit->user->id === $user->id;
            $userMatchesUnit = !$unit->user && (
                ($unit->unit_name === 'Fakultas' && $user->isFaculty()) ||
                ($unit->unit_name === 'Jurusan' && $user->isDepartment()) ||
                ($unit->unit_name === 'Program Studi' && $user->isProgram())
            );

            return $userInUnit || $userMatchesUnit || $user->isAuditor();
        });
    }

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
        return $user->isAuditee() || $user->isAuditor();
    }

    public function viewSurvey(User $user, Instrument $instrument): bool
    {
        return $user->isAuditee();
    }

    public function submitAuditResults(User $user, Instrument $instrument): bool
    {
        return $user->isAuditor();
    }

    public function submitComplianceResults(User $user, Instrument $instrument): bool
    {
        return $user->isAuditor();
    }

    public function submitNoncomplianceResults(User $user, Instrument $instrument): bool
    {
        return $user->isAuditor();
    }

    public function submitPTK(User $user, Instrument $instrument): bool
    {
        return $user->isAuditor();
    }

    public function submitPTP(User $user, Instrument $instrument): bool
    {
        return $user->isAuditor();
    }
}

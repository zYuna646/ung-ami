<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{
    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Question $question): bool
    {
        return $question->units->contains(function ($unit) use ($user) {
            $userInUnit = $unit->user && $unit->user->id === $user->id;
            $userMatchesUnit = !$unit->user && (
                ($unit->unit_name === 'Fakultas' && $user->isFaculty()) ||
                ($unit->unit_name === 'Jurusan' && $user->isDepartment()) ||
                ($unit->unit_name === 'Program Studi' && $user->isProgram())
            );

            return $userInUnit || $userMatchesUnit || $user->isAuditor();
        });
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
    public function update(User $user, Question $question): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Question $question): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Question $question): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Question $question): bool
    {
        //
    }
}

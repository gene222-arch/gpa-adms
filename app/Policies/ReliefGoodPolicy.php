<?php

namespace App\Policies;

use App\Models\ReliefGood;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReliefGoodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return auth()->check();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ReliefGood  $reliefGood
     * @return mixed
     */
    public function view(User $user, ReliefGood $reliefGood)
    {
        return $reliefGood->users->map(fn($reliefUser) => $user->id === $reliefUser->id)->first();
    }


    public function getRecipients(User $user)
    {
        return $this->determineIfUserIsVolunteer($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->determineIfUserIsVolunteer($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ReliefGood  $reliefGood
     * @return mixed
     */
    public function update(User $user, ReliefGood $reliefGood)
    {
        return $this->determineVolunteerIsOwnerOfReliefGood($user, $reliefGood);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ReliefGood  $reliefGood
     * @return mixed
     */
    public function delete(User $user, ReliefGood $reliefGood)
    {
        return $this->determineVolunteerIsOwnerOfReliefGood($user, $reliefGood);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ReliefGood  $reliefGood
     * @return mixed
     */
    public function restore(User $user, ReliefGood $reliefGood)
    {
        return $this->determineVolunteerIsOwnerOfReliefGood($user, $reliefGood);;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ReliefGood  $reliefGood
     * @return mixed
     */
    public function forceDelete(User $user, ReliefGood $reliefGood)
    {
        return $this->determineVolunteerIsOwnerOfReliefGood($user, $reliefGood);;
    }

    /**
     * Determine if the user has a role of volunteer and owns the data/relief good
     *
     * @param User $user
     * @param ReliefGood $reliefGood
     * @return boolean
     */
    public function determineVolunteerIsOwnerOfReliefGood(User $user, ReliefGood $reliefGood)
    {
        return $user->hasRole('volunteer') && $reliefGood->users->map(fn($reliefUser) => $reliefUser->id === $user->id);
    }

    public function determineIfUserIsVolunteer(User $user)
    {
        return $user->hasRole('volunteer');
    }

    public function determineIfUserIsRecipient(User $user)
    {
        return $user->hasRole('recipient');
    }

}

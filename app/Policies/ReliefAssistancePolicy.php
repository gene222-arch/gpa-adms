<?php

namespace App\Policies;

use App\Models\ReliefGood;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReliefAssistancePolicy
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
        //
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
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
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
        //
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
        //
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
        //
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
        //
    }
}

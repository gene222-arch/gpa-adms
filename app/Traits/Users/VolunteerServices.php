<?php

namespace App\Traits\Users;

use phpDocumentor\Reflection\Types\Boolean;

trait VolunteerServices
{
    /**
     * Fetch all users with a role of 'volunteer'
     *
     * @return collection
     */

    public function volunteers()
    {
        return $this->whereHas('roles', fn($q) => $q->where('name', 'volunteer'))->get();
    }

    /**
     * Attach new relief data to Pivot Table ("user_relief_good")
     *
     * @return boolean
     */
    public function giveReliefAssistanceTo($reliefGood, $recipient_id): bool
    {
        return \boolval($this->relief_goods()->attach($reliefGood, [ 'recipient_id' => $recipient_id ]));
    }

    /**
     * Detach a users relief assistance in the Pivot Table("user_relief_good")
     *
     * @return boolean
     */
    public function removeReliefAssistanceTo($reliefAsstId): bool
    {
        return \boolval($this->relief_goods()->detach($reliefAsstId));
    }

    /**
     * Get the last inserted relief assistance
     *
     * @return object
     */
    public function getLastCreatedReliefAsst()
    {
        return $this->relief_goods()
                    ->with('users')
                    ->latest()
                    ->get()
                    ->first();
    }

    public function findReliefAsst($reliefAsstId)
    {
        return $this->relief_goods()
                    ->with('users')
                    ->wherePivot('relief_good_id', $reliefAsstId)
                    ->get()
                    ->first();
    }

    /**
     * Relief Assistance which was approved by the admin
     *
     * @return collections
     */
    public function approvedReliefAssistance()
    {
        return $this->relief_goods()
                    ->wherePivot('is_approved', true)
                    ->get();
    }

    /**
     *
     */
    public function reliefAssistanceToSend()
    {
        return $this->relief_goods()
                    ->wherePivot('is_approved', true)
                    ->wherePivot('is_received', true)
                    ->get();
    }

    /**
     * Relief Assistance which is not sent
     *
     * @return collections
     */
    public function onProcessReliefAssistance()
    {
        return $this->relief_goods()
                    ->where('is_sent', false)
                    ->get();
    }

    /**
     * Check if the user has a role of 'volunteer'
     *
     * @return boolean
     */

    public function isVolunteer(): bool
    {
        return $this->hasRole('volunteer');
    }


}

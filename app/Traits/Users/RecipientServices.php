<?php

namespace App\Traits\Users;

trait RecipientServices
{

    /**
     * Fetch all users with a role of 'recipeints'
     *
     * @return collection
     */
    public function recipients()
    {
        return $this->whereHas('roles', fn($q) => $q->where('name', 'recipient'))
                    ->orderBy('name', 'asc')
                    ->get();
    }

    /**
     * Check if the user has a role of 'Recipeints'
     *
     * @return boolean
     */
    public function isRecipient(): bool
    {
        return $this->hasRole('recipient');
    }


}

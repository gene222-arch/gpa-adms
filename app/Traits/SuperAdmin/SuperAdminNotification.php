<?php

namespace App\Traits\SuperAdmin;

use App\Notifications\AdminResetPasswordNotification;
use App\Notifications\OnApproveReliefAssistanceNotification;
use App\Notifications\OnDispatchReliefAssistanceNotification;
use App\Notifications\OnReceiveReliefAssistanceNotification;

trait SuperAdminNotification
{

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    /**
     * Notif User
     */

    /**
     * Notifying the user when he's relief assistance is approve
     *
     * @param [int] $userId
     * @return void
     */
    public function notifyUserOnApproveReliefAsst($userId)
    {
        $this->user->find($userId)->notify(new OnApproveReliefAssistanceNotification());
    }

    /**
     * Notifying the user when he's relief assistance was receive
     *
     * @param [int] $userId
     * @return void
     */
    public function notifyUserOnReceiveReliefAsst($userId)
    {
        $this->user->find($userId)->notify(new OnReceiveReliefAssistanceNotification());
    }

    /**
     * Notifying the user when he's relief assistance was dispatch
     *
     * @param [int] $userId
     * @return void
     */
    public function notifyUserOnDispatchReliefAsst($userId)
    {
        $this->user->find($userId)->notify(new OnDispatchReliefAssistanceNotification());
    }

}

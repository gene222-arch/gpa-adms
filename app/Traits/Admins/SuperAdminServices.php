<?php

namespace App\Traits\Admins;

use App\Models\User;

trait SuperAdminServices
{

    protected $user;

    public function __construct()
    {
        $this->user = new User;
    }

    /**
     * Getting the super admin
     *
     * @return object
     */
    public function superAdmin()
    {
        return $this->whereHas('roles', fn($q) => $q->where('name', 'super_admin'))->first();
    }

    /**
     * * Getting all users with relief assistance
     *
     * @return collection
     */
    public function getUsersWithReliefAssistance()
    {
        return $this->user
                    ->has('relief_goods')
                    ->with('relief_goods')
                    ->whereHas('roles', fn($q) => $q->where('name', 'volunteer'))
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    /**
     * * Approving a users relief assistance
     *
     * @return boolean
     */
    public function approveReliefAssistance($userId, $reliefGoodId): bool
    {
        return \boolval($this->user
                                ->find($userId)
                                ->relief_goods()
                                ->wherePivot('is_sent', false)
                                ->updateExistingPivot($reliefGoodId,
                                [
                                    'is_approved' => true,
                                    'approved_at' => now()
                                ])
                );
    }

    /**
     * * disapproving a users relief assistance
     *
     * @return boolean
     */
    public function disapproveReliefAssistance($userId, $reliefGoodId): bool
    {
        return \boolval($this->user
                                ->find($userId)
                                ->relief_goods()
                                ->wherePivot('is_sent', false)
                                ->updateExistingPivot($reliefGoodId,
                                [
                                    'is_approved' => false,
                                    'approved_at' => null
                                ])
                );
    }

    /**
     * Setting the is_received value to true when the admin collect/receive user's relief assistance
     *
     * @return boolean
     */
    public function reliefAsstHasReceived($userId, $reliefGoodId): bool
    {
        return \boolval($this->user
                            ->find($userId)
                            ->relief_goods()
                            ->wherePivot('is_sent', false)
                            ->wherePivot('is_approved', true)
                            ->updateExistingPivot($reliefGoodId,
                            [
                                'is_received' => true,
                                'received_at' => now(),
                            ]));
    }

    /**
     * Setting the is_received value to false when the admin relieve the user's relief assistance
     *
     * @param [int] $userId
     * @param [int] $reliefGoodId
     * @return void
     */
    public function relieveReceivedReliefAsst($userId, $reliefGoodId)
    {
        return $this->user
                    ->find($userId)
                    ->relief_goods()
                    ->wherePivot('is_sent', false)
                    ->wherePivot('is_approved', true)
                    ->updateExistingPivot($reliefGoodId,
                    [
                        'is_received' => false,
                        'received_at' => NULL,
                    ]);
    }



    /**
     * Setting the is_sent value to true after the admin notify the users that the R.A was received
     *
     * @param [int] $userId
     * @param [int] $reliefAsstId
     * @return void
     */
    public function dispatchReliefAsstOf($userId, $reliefGoodId, $recipientId)
    {
        return $this->user
                    ->find($userId)
                    ->relief_goods()
                    ->wherePivot('is_approved', true)
                    ->wherePivot('is_received', true)
                    ->wherePivot('recipient_id', $recipientId)
                    ->updateExistingPivot($reliefGoodId,
                    [
                        'is_sent' => true,
                        'sent_at' => now()
                    ]);
    }

    /**
     * Getting all the users with dispatched relief asst
     *
     * @return collection
     */
    public function getDispatchedReliefAsst()
    {
        return $this->user
                    ->whereHas('relief_goods', fn($q) => $q->where(
                    [
                        'is_approved' => true,
                        'is_received' => true,
                        'is_sent' => true
                    ]))
                    ->get();
    }

    /**
     * Undocumented function
     *
     * @return collection
     */
    public function undispatchReliefAsst()
    {
        return $this->user
                    ->whereHas('relief_goods', fn($q) => $q->where(
                    [
                        'is_approved' => false,
                        'is_sent' => false
                    ]))
                    ->get();
    }


    /**
     * ? Detaching a user's relief assistance
     *
     * @param $userId
     * @param $reliefGoodId
     */
    public function removeReliefAssistanceOf($userId, $reliefGoodId)
    {
        return $this->user
                    ->find($userId)
                    ->relief_goods()
                    ->detach($reliefGoodId);
    }

}

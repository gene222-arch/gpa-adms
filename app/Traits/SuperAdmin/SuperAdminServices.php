<?php

namespace App\Traits\SuperAdmin;

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
                    ->has('reliefGoods')
                    ->with('reliefGoods')
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
                                ->reliefGoods()
                                ->wherePivot('is_dispatched', false)
                                ->wherePivot('is_received', false)
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
                                ->reliefGoods()
                                ->wherePivot('is_dispatched', false)
                                ->wherePivot('is_received', false)
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
                            ->reliefGoods()
                            ->wherePivot('is_dispatched', false)
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
                    ->reliefGoods()
                    ->wherePivot('is_dispatched', false)
                    ->wherePivot('is_approved', true)
                    ->updateExistingPivot($reliefGoodId,
                    [
                        'is_received' => false,
                        'received_at' => NULL,
                    ]);
    }



    /**
     * Setting the is_dispatched value to true after the admin notify the users that the R.A was received
     *
     * @param [int] $volunteerId
     * @param [int] $reliefAsstId
     * @return boolean
     */
    public function dispatchReliefAsstOf($volunteerId, $reliefGoodId, $recipientId, $dispatchAt): bool
    {
        return \boolval($this->user
                    ->find($volunteerId)
                    ->reliefGoods()
                    ->wherePivot('is_approved', true)
                    ->wherePivot('is_received', true)
                    ->wherePivot('recipient_id', $recipientId)
                    ->updateExistingPivot($reliefGoodId,
                    [
                        'is_dispatched' => true,
                        'dispatched_at' => $dispatchAt
                    ]));
    }


    /**
     * Setting the is_dispatched value to true after the admin notify the users that the R.A was received
     *
     * @param [int] $userId
     * @param [int] $reliefAsstId
     * @return boolean
     */
    public function undispatchReliefAsstOf($userId, $reliefGoodId, $recipientId): bool
    {
        return \boolval($this->user
                    ->find($userId)
                    ->reliefGoods()
                    ->wherePivot('is_approved', true)
                    ->wherePivot('is_received', true)
                    ->wherePivot('recipient_id', $recipientId)
                    ->updateExistingPivot($reliefGoodId,
                    [
                        'is_dispatched' => false,
                        'dispatched_at' => NULL
                    ]));
    }
    /**
     * Getting all the users with dispatched relief asst
     *
     * @return collection
     */
    public function getDispatchedReliefAsst()
    {
        return $this->user
                    ->whereHas('reliefGoods', fn($q) => $q->where(
                    [
                        'is_approved' => true,
                        'is_received' => true,
                        'is_dispatched' => true
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
                    ->whereHas('reliefGoods', fn($q) => $q->where(
                    [
                        'is_approved' => false,
                        'is_dispatched' => false
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
                    ->reliefGoods()
                    ->detach($reliefGoodId);
    }

}

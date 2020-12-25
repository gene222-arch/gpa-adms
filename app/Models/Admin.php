<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\AdminResetPasswordNotification;
use App\Notifications\hasReceivedReliefAsst;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $guard = 'admin';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $user;

    public function __construct()
    {
        $this->user = new User;
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    /**
     * * Super Admin
     */
    public function superAdmin()
    {
        return $this->whereHas('roles', fn($q) => $q->where('name', 'super_admin'))->first();
    }

    /**
     * * Fetching all users with relief assistance
     */
    public function getUserWithReliefAssistance()
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
     */
    public function approveReliefAssistance($userId, $reliefGoodId)
    {
        return $this->user
                    ->find($userId)
                    ->relief_goods()
                    ->wherePivot('is_sent', false)
                    ->updateExistingPivot($reliefGoodId, [
                        'is_approved' => true,
                        'approved_at' => now()
                    ]);
    }

    /**
     * * disapproving a users relief assistance
     */
    public function disapproveReliefAssistance($userId, $reliefGoodId)
    {
        return $this->user
                    ->find($userId)
                    ->relief_goods()
                    ->wherePivot('is_sent', false)
                    ->updateExistingPivot($reliefGoodId, [
                        'is_approved' => false,
                        'approved_at' => null
                    ]);
    }

    public function reliefAsstHasReceived($userId, $reliefGoodId)
    {
        return $this->user
                    ->find($userId)
                    ->relief_goods()
                    ->wherePivot('is_approved', true)
                    ->updateExistingPivot($reliefGoodId, [
                        'is_received' => true,
                        'received_at' => now(),
                    ]);
    }

    public function relieveReceivedReliefAsst($userId, $reliefGoodId)
    {
        return $this->user
                    ->find($userId)
                    ->relief_goods()
                    ->wherePivot('is_approved', true)
                    ->updateExistingPivot($reliefGoodId, [
                        'is_received' => false,
                        'received_at' => NULL,
                    ]);
    }


    /**
     * * Processing a users relief assistance
     */
    public function processedReliefAssistance($userId, $reliefGoodId)
    {
        return $this->user
                    ->find($userId)
                    ->relief_goods()
                    ->wherePivot('is_approved', true)
                    ->updateExistingPivot($reliefGoodId, [
                        'is_sent' => true,
                        'sent_at' => now()
                    ]);
    }

    /**
     * * Fetching all users with processed relief assistance
     */
    public function getUsersWithProcessedReliefAssistance()
    {
        return $this->user
                    ->whereHas('relief_goods', fn($q) => $q->where(
                    [
                        'is_approved' => true,
                        'is_sent' => true
                    ]))
                    ->get();
    }

    /**
     * * Fetching all users with processed relief assistance
     */
    public function getUsersNonProcessedReliefAssistance()
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

    /**
     * Notif User
     */

    public function notifyUserOnReceivedReliefAsst($userId)
    {
        $this->user->find($userId)->notify(new hasReceivedReliefAsst());
    }

}

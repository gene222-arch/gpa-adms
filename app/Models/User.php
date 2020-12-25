<?php

namespace App\Models;

use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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



    /**
    |--------------------------------------------------------------------------
    |  Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * belongsToMany Relationship with 'relief_good' table
     *
     * @return type Many to Many
     */
    public function relief_goods()
    {
        return $this->belongsToMany(ReliefGood::class, 'user_relief_good')
                    ->withPivot(
                        'constituent_id',
                        'is_approved', 'approved_at',
                        'is_received', 'received_at',
                        'is_sent', 'sent_at'
                    )
                    ->orderByPivot('created_at', 'desc')
                    ->withTimestamps();
    }

    public function relief_goods_by_constituents()
    {
        return $this->belongsToMany(ReliefGood::class, 'user_relief_good', 'constituent_id', 'relief_good_id')
                    ->withPivot(
                        'user_id',
                        'is_sent', 'sent_at'
                    )
                    ->with('users')
                    ->withTimestamps()
                    ->orderByPivot('created_at', 'desc');
    }

    /**
    |--------------------------------------------------------------------------
    | Custom Functions for Roles
    |--------------------------------------------------------------------------
    */

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
     * Fetch all users with a role of 'constituent'
     *
     * @return collection
     */
    public function constituents()
    {
        return $this->whereHas('roles', fn($q) => $q->where('name', 'constituent'))
                    ->orderBy('name', 'asc')
                    ->get();
    }

    /**
     * Check if the user has a role of 'Volunteer'
     *
     * @return boolean
     */
    public function isVolunteer(): bool
    {
        return $this->hasRole('volunteer');
    }

    /**
     * Check if the user has a role of 'Constituent'
     *
     * @return boolean
     */
    public function isConstituent(): bool
    {
        return $this->hasRole('constituent');
    }

    /**
    |--------------------------------------------------------------------------
    | relief_goods Table Relationship
    |--------------------------------------------------------------------------
    */

    /**
     * Attach new relief data to Pivot Table ("user_relief_good")
     *
     *
     */
    public function giveReliefAssistanceTo($reliefGood, $constituent_id)
    {
        return $this->relief_goods()->attach($reliefGood, [ 'constituent_id' => $constituent_id ]);
    }

    /**
     * Detach a users relief assistance in the Pivot Table("user_relief_good")
     *
     * @return array
     */
    public function removeReliefAssistanceTo($constituent_id)
    {
        return $this->relief_goods()->detach($constituent_id);
    }

    /**
     * Todo
     * Allow users to view the relief he/she created/sent that is still pending
     */
    public function onProcessReliefAssistance()
    {
        return $this->relief_goods()
                    ->where('is_sent', false)
                    ->get();
    }

    /**
     * Todo
     * Allow users to view the relief he/she created/sent that is approved by the Admin
     */
    public function approvedReliefAssistance()
    {
        return $this->relief_goods()
                    ->wherePivot('is_approved', true)
                    ->get();
    }

    /**
     * Todo
     * Allow users to view the relief he/she created/sent that was already processed
     */
    public function processedReliefAssistance()
    {
        return $this->relief_goods()
                    ->wherePivot('is_approved', true)
                    ->wherePivot('is_received', true)
                    ->get();
    }

    /**
     * Todo
     * Allow users to view the constituents who received his/her relief assistance
     */

    public function constituentsWithReceivedReliefAsst()
    {
        return $this->relief_goods()
                    ->wherePivot('is_approved', true)
                    ->wherePivot('is_received', true)
                    ->wherePivot('is_sent', true)
                    ->get();
    }


}

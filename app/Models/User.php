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
     * Check if the user has a role of 'Volunteer'
     *
     * @return boolean
     */
    public function isVolunteer(): bool
    {
        return $this->hasRole('volunteer');
    }

    public function isConstituent(): bool
    {
        return $this->hasRole('constituent');
    }

    /**
     *
     * @return type Many to Many
     */
    public function relief_goods()
    {
        return $this->belongsToMany(ReliefGood::class, 'user_relief_good')
                    ->withPivot(
                        'is_approved', 'approved_at',
                        'is_received', 'received_at',
                        'is_sent', 'sent_at')
                    ->withTimestamps()
                    ->orderByPivot('created_at', 'desc');
    }

    /**
     * ? Attach/Sync new relief data to Pivot Table ("user_relief_good")
     */
    public function giveReliefAssistanceTo($reliefGood): void
    {
        $this->relief_goods()->syncWithoutDetaching($reliefGood);
    }

    /**
     * ? Detach a users relief assistance in the Pivot Table("user_relief_good")
     */
    public function removeReliefAssistanceTo($id): void
    {
        $this->relief_goods()->detach($id);
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

<?php

namespace App\Models;

use App\Traits\Users\RecipientServices;
use App\Traits\Users\VolunteerServices;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * Imported Traits
     */
    use HasFactory, Notifiable, HasRoles;
    /**
     * Custom Traits
     */
    use VolunteerServices, RecipientServices;
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
     * belongsToMany Relationship with 'reliefGoods' table
     * idName: 'user_id'
     * reliefGoodIdName: 'relief_id'
     *
     * @return type Many to Many
     */
    public function reliefGoods()
    {
        return $this->belongsToMany(
            ReliefGood::class,
            'user_relief_good',
            'user_id',
            'relief_good_id'
            )
                    ->withPivot(
                        'id',
                        'recipient_id',
                        'is_approved', 'approved_at',
                        'is_received', 'received_at',
                        'is_dispatched', 'dispatched_at'
                    )
                    ->orderByPivot('created_at', 'desc')
                    ->withTimestamps();
    }

    /**
     * belongsToMany Relationship with 'reliefGoods' table
     * idName: 'recipient_id'
     * reliefGoodIdName: 'relief_id'
     *
     * @return type Many to Many
     */
    public function reliefGoodsByRecipients()
    {
        return $this->belongsToMany(
            ReliefGood::class,
            'user_relief_good',
            'recipient_id',
            'relief_good_id'
            )
                    ->withPivot(
                        'id', 'user_id',
                        'is_dispatched', 'dispatched_at'
                    )
                    ->with('users')
                    ->withTimestamps()
                    ->orderByPivot('created_at', 'desc');
    }

}

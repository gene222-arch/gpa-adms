<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReliefGood extends Model
{
    use HasFactory;

    protected $table = 'relief_goods';
    public $timestamps = true;

    protected $fillable =
    [
        'category',
        'name',
        'quantity',
        'to'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_relief_good');
    }

}

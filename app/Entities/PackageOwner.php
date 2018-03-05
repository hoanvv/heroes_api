<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageOwner extends Model
{
    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'rating'
    ];

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function requestShips()
    {
        return $this->hasMany('App\Entities\RequestShip');
    }
}

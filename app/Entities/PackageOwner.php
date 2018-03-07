<?php

namespace App\Entities;

class PackageOwner extends User
{
    public $timestamps = false;

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

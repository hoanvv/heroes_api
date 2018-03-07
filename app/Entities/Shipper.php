<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    public $timestamps = false;

    const OFFLINE_SHIP = 0;
    const ONLINE_SHIP = 1;

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'rating',
        'avatar',
        'identity_card',
        'is_online'
    ];

    public function isOnline()
    {
        return $this->is_online = Shipper::ONLINE_SHIP;
    }

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function vehicles()
    {
        return $this->hasMany('App\Entities\Vehicle');
    }

    public function drivingLicenses()
    {
        return $this->hasMany('App\Entities\DrivingLicense');
    }

    public function trips()
    {
        return $this->hasMany('App\Entities\Trip');
    }
}

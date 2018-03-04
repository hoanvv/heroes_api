<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
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
}

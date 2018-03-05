<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'request_ship_id',
        'shipper_id',
        'pickup_time',
        'dropoff_time',
        'package_owner_rating',
        'receiver_rating',
        'shipper_rating',
    ];

    // Relationships
    public function shipper()
    {
        return $this->belongsTo('App\Entities\Shipper');
    }

    public function requestShip()
    {
        return $this->belongsTo('App\Entities\RequestShip');
    }
}

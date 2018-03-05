<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class RequestShip extends Model
{
    protected $fillable = [
        'user_id',
        'package_type_id',
        'promo_code_id',
        'receiver_name',
        'phone',
        'pickup_location',
        'destination',
        'price',
        'distance',
        'note',
        'status'
    ];

    // Relationship
    public function packageType()
    {
        return $this->belongsTo('App\Entities\PackageType');
    }

    public function promoCode()
    {
        return $this->belongsTo('App\Entities\PromoCode');
    }

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function trips()
    {
        return $this->hasOne('App\Entities\Trip');
    }

    public function requestTrackings()
    {
        return $this->hasMany('App\Entities\RequestTracking');
    }

}

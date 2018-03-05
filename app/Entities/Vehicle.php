<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'shipper_id',
        'image1',
        'image2'
    ];

    public function shipper()
    {
        return $this->belongsTo('App\Entities\Shipper');
    }

    public function insurances()
    {
        return $this->hasMany('App\Entities\Insurance');
    }

    public function vehicleRegistration()
    {
        return $this->hasOne('App\Entities\VehicleRegistration');
    }
}

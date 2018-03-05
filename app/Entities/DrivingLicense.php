<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class DrivingLicense extends Model
{
    protected $fillable = [
        'shipper_id',
        'front_image',
        'back_image',
        'number_license',
        'type',
        'date'
    ];

    public function shipper()
    {
        return $this->belongsTo('App\Entities\Shipper');
    }
}

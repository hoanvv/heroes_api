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

}

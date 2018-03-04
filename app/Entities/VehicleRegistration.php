<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class VehicleRegistration extends Model
{
    protected $fillable = [
        'vehicle_id',
        'front_image',
        'back_image',
        'number_registration',
        'number_plate',
        'date',
    ];
}

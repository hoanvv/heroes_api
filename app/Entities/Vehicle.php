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
}

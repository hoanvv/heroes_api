<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable = [
        'vehicle_id',
        'front_image',
        'back_image',
        'expiration_date'
    ];

    public function vehicle()
    {
        return $this->belongsTo('App\Entities\Vehicle');
    }
}

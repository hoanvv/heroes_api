<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageOwner extends Model
{
    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'rating'
    ];
}

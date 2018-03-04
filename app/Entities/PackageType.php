<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageType extends Model
{
    protected $fillable = [
        'name',
        'weight',
        'size',
        'warning',
        'price'
    ];
}

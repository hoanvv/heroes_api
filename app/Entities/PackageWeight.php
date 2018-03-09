<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageWeight extends Model
{
    protected $fillable = [
        'name',
        'start_weight',
        'end_weight',
        'price'
    ];
}

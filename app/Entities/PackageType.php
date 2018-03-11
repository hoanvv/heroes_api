<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageType extends Model
{
    const NORMAL_PACKAGE = 0;
    const OPTIONAL_PACKAGE = 1;

    protected $fillable = [
        'name',
        'optional_package',
        'description',
        'start_weight',
        'end_weight',
        'price'
    ];

    public function isOptional()
    {
        return $this->optional_package == PackageType::OPTIONAL_PACKAGE;
    }

    public function isFree()
    {
        return $this->price == 0;
    }
    // Relationship
    public function requestShips()
    {
        return $this->hasMany('App\Entities\RequestShip');
    }
}

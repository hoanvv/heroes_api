<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class RequestShip extends Model
{
    const CANCELLED_REQUEST = 0;
    const WAITING_REQUEST = 1;
    const ACCEPTED_REQUEST = 2;

    protected $fillable = [
        'package_owner_id',
        'package_type_id',
        'promo_code_id',
        'receiver_name',
        'phone',
        'pickup_location',
        'destination',
        'note',
        'status'
    ];

    public function isCancelled()
    {
        return $this->status == RequestShip::CANCELLED_REQUEST; // status = 0
    }

    public function isDelivering()
    {
        return $this->status == RequestShip::WAITING_REQUEST; // status = 1
    }

    public function isAccepted()
    {
        return $this->status == RequestShip::ACCEPTED_REQUEST; // status = 2
    }

}

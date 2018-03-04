<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    const CANCELLED_TRIP = 0;
    const DELIVERING_TRIP = 1;
    const COMPLETED_TRIP = 2;

    protected $fillable = [
        'request_id',
        'shipper_id',
        'pickup_time',
        'dropoff_time',
        'package_owner_rating',
        'receiver_rating',
        'shipper_rating',
        'status'
    ];

    public function isCancelled()
    {
        return $this->status == Trip::CANCELLED_TRIP; // status = 0
    }

    public function isDelivering()
    {
        return $this->status == Trip::DELIVERING_TRIP; // status = 1
    }

    public function isCompleted()
    {
        return $this->status == Trip::COMPLETED_TRIP; // status = 2
    }
}

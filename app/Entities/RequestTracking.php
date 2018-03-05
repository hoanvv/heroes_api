<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class RequestTracking extends Model
{
    const CANCELLED_REQUEST = 0;
    const WAITING_REQUEST = 1;
    const ACCEPTED_REQUEST = 2;
    const CANCELLED_TRIP = 3;
    const WAITING_TRIP = 4;
    const DELIVERING_TRIP = 5;
    const COMPLETED_TRIP = 6;

    protected $fillable = [
        'request_ship_id',
        'user_id',
        'status',
        'changed_at'
    ];

    // Method for getting status
    public function isCancelledRequest()
    {
        return $this->status == RequestShip::CANCELLED_REQUEST;
    }

    public function isWaitingRequest()
    {
        return $this->status == RequestShip::WAITING_REQUEST;
    }

    public function isAcceptedRequest()
    {
        return $this->status == RequestShip::ACCEPTED_REQUEST;
    }

    public function isCancelledTrip()
    {
        return $this->status == RequestShip::CANCELLED_TRIP;
    }

    public function isWaitingTrip()
    {
        return $this->status == RequestShip::WAITING_TRIP;
    }

    public function isDeliveringTrip()
    {
        return $this->status == RequestShip::DELIVERING_TRIP;
    }

    public function isCompletedTrip()
    {
        return $this->status == RequestShip::COMPLETED_TRIP;
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function requestShip()
    {
        return $this->belongsTo('App\Entities\RequestShip');
    }
}

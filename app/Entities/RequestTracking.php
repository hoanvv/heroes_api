<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class RequestTracking extends Model
{
    const CANCELLED_REQUEST = 0;
    const WAITING_REQUEST = 1;
    const ACCEPTED_REQUEST = 2;
    const CANCELLED_TRIP = 3;
    const DELIVERING_TRIP = 4;
    const COMPLETED_TRIP = 5;

    protected $fillable = [
        'request_ship_id',
        'user_id',
        'status',
        'changed_at'
    ];

    // Method for getting status
    public function isCancelledRequest()
    {
        return $this->status == RequestTracking::CANCELLED_REQUEST;
    }

    public function isWaitingRequest()
    {
        return $this->status == RequestTracking::WAITING_REQUEST;
    }

    public function isAcceptedRequest()
    {
        return $this->status == RequestTracking::ACCEPTED_REQUEST;
    }

    public function isCancelledTrip()
    {
        return $this->status == RequestTracking::CANCELLED_TRIP;
    }

    public function isDeliveringTrip()
    {
        return $this->status == RequestTracking::DELIVERING_TRIP;
    }

    public function isCompletedTrip()
    {
        return $this->status == RequestTracking::COMPLETED_TRIP;
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

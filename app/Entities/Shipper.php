<?php

namespace App\Entities;

use Illuminate\Support\Facades\DB;

class Shipper extends User
{
    public $timestamps = false;

    const OFFLINE_SHIP = 0;
    const ONLINE_SHIP = 1;

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'rating',
        'avatar',
        'identity_card',
        'is_online'
    ];
    // Utility functions
    public function isOnline()
    {
        return $this->is_online = Shipper::ONLINE_SHIP;
    }
    // relationship
    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function vehicles()
    {
        return $this->hasMany('App\Entities\Vehicle');
    }

    public function drivingLicenses()
    {
        return $this->hasMany('App\Entities\DrivingLicense');
    }

    public function trips()
    {
        return $this->hasMany('App\Entities\Trip');
    }

    public static function getRequestShipList($shipperId)
    {
        $records = DB::select(
            'SELECT rs.id, t.created_at, rs.pickup_location_address, rs.destination_address, rt1.status, rs.price'
            . ' FROM trips t'
            . ' JOIN request_ships rs ON (t.request_ship_id = rs.id)'
            . ' JOIN request_trackings rt1 ON (rs.id = rt1.request_ship_id)'
            . ' LEFT OUTER JOIN request_trackings rt2 ON (rs.id = rt2.request_ship_id AND'
            . ' (rt1.changed_at < rt2.changed_at OR rt1.changed_at = rt2.changed_at AND rt1.id < rt2.id))'
            . ' WHERE rt2.id IS NULL AND t.shipper_id = :shipper_id',
            ['shipper_id' => $shipperId]
        );

        return $records;
    }

    public static function getRequestShip($shipperId, $requestShipId)
    {
        $records = DB::select(
           'SELECT rs.*, u.first_name, u.last_name, u.phone, rt1.status'
            . ' FROM trips t'
            . ' JOIN request_ships rs ON (t.request_ship_id = rs.id)'
            . ' JOIN users u ON (rs.user_id = u.id)'
            . ' JOIN request_trackings rt1 ON (rs.id = rt1.request_ship_id)'
            . ' LEFT OUTER JOIN request_trackings rt2 ON (rs.id = rt2.request_ship_id AND'
            . ' (rt1.changed_at < rt2.changed_at OR rt1.changed_at = rt2.changed_at AND rt1.id < rt2.id))'
            . ' WHERE rt2.id IS NULL AND t.shipper_id = :shipper_id AND rs.id = :request_ship_id',
            ['shipper_id' => $shipperId, 'request_ship_id' => $requestShipId]
        );
        if (empty($records)) {
            return null;
        } else {
            return $records[0];
        }
    }
}

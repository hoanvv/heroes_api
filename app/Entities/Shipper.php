<?php

namespace App\Entities;

use Illuminate\Support\Facades\DB;

class Shipper extends User
{
    public $timestamps = false;

    const OFFLINE_SHIP = 0;
    const ONLINE_SHIP = 1;
    const STATUS_DEFAULT_SHIPPER = 1;
    const STATUS_NORMAL_SHIPPER = 0;

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'rating',
        'avatar',
        'identity_card',
        'is_online',
        'is_default'
    ];
    // Utility functions
    public function isOnline()
    {
        return $this->is_online = Shipper::ONLINE_SHIP;
    }

    public function isDefault()
    {
        return $this->is_default = Shipper::STATUS_DEFAULT_SHIPPER;
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

    public static function getNotCompletedRequestShipList($shipperId)
    {
        $records = DB::select(
            'SELECT rs.pickup_location, rs.destination, rt1.status, rs.id'
            . ' FROM trips t'
            . ' JOIN request_ships rs ON (t.request_ship_id = rs.id)'
            . ' JOIN request_trackings rt1 ON (rs.id = rt1.request_ship_id)'
            . ' LEFT OUTER JOIN request_trackings rt2 ON (rs.id = rt2.request_ship_id AND'
            . ' (rt1.changed_at < rt2.changed_at OR rt1.changed_at = rt2.changed_at AND rt1.id < rt2.id))'
            . ' WHERE rt2.id IS NULL AND t.shipper_id = :shipper_id'
            . ' AND (rt1.status = :status1 OR rt1.status = :status2)',
            [
                'shipper_id' => $shipperId,
                'status1' => RequestTracking::ACCEPTED_REQUEST,
                'status2' => RequestTracking::DELIVERING_TRIP
            ]
        );

        return $records;
    }

    public static function getCancelledRequestList($shipperId)
    {
        $records = DB::select(
            'SELECT rs.pickup_location, rs.destination, rt1.status, rs.id'
            . ' FROM trips t'
            . ' JOIN request_ships rs ON (t.request_ship_id = rs.id)'
            . ' JOIN request_trackings rt1 ON (rs.id = rt1.request_ship_id)'
            . ' LEFT OUTER JOIN request_trackings rt2 ON (rs.id = rt2.request_ship_id AND'
            . ' (rt1.changed_at < rt2.changed_at OR rt1.changed_at = rt2.changed_at AND rt1.id < rt2.id))'
            . ' WHERE rt2.id IS NULL AND t.shipper_id = :shipper_id'
            . ' AND rt1.status = :status',
            [
                'shipper_id' => $shipperId,
                'status' => RequestTracking::CANCELLED_REQUEST,
            ]
        );

        return $records;
    }
    public static function getTotalOutcome($factor, $shipperId)
    {
        $condition = '';
        $hour = " 00:00:01";
        switch ($factor) {
            case "DAILY":
                $start = date('Y-m-d', time()) . ' ' . $hour;
                $end = date('Y-m-d', time() + 86400) . ' ' . $hour;
                $condition = "(request_trackings.changed_at between '{$start}' and '{$end}') ";
                error_log($condition);
                break;
            case "WEEKLY":
                $condition = "YEARWEEK(`changed_at`, 1) = YEARWEEK(CURDATE(), 1)";
                break;
            case "MONTHLY":
                $currentMonth = (int)date('m');
                $currentYear = (int)date('Y');
                $condition = "MONTH(changed_at) = {$currentMonth} AND YEAR(changed_at) = {$currentYear}";
                break;
            case "TOTAL":
                $condition = 1;
                break;
            default:
                return ['total' => 0];
        }

        $query = 'SELECT sum(price) as total'
            .' from trips'
            .' join request_ships on (trips.request_ship_id = request_ships.id)'
            .' join request_trackings on (request_ships.id = request_trackings.request_ship_id)'
            .' where request_trackings.status = 4'
            ." and trips.shipper_id = {$shipperId}"
            .' and ' . $condition;

        $record = DB::select($query);

        if (!$record[0]->total) {
            return ['total' => 0];
        } else {
            return $record[0];
        }
    }
}

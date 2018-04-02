<?php

namespace App\Entities;

use Illuminate\Support\Facades\DB;

class PackageOwner extends User
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'rating'
    ];

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function requestShips()
    {
        return $this->hasMany('App\Entities\RequestShip');
    }

    public static function getRequestShipList($userId)
    {
        $records = DB::select(
            'SELECT rs.id, rs.created_at, rs.pickup_location_address, rs.destination_address, rt1.status'
            . ' FROM request_ships rs'
            . ' JOIN request_trackings rt1 ON (rs.id = rt1.request_ship_id)'
            . ' LEFT OUTER JOIN request_trackings rt2 ON (rs.id = rt2.request_ship_id AND'
            . ' (rt1.changed_at < rt2.changed_at OR rt1.changed_at = rt2.changed_at AND rt1.id < rt2.id))'
            . ' WHERE rt2.id IS NULL AND rs.user_id = :user_id',
            ['user_id' => $userId]
        );

        return $records;
    }

    public static function getRequestShip($packageOwnerId, $requestShipId, $isPicked)
    {
        $sql = "";
        if ($isPicked) {
            $sql = 'SELECT rs.*, u.first_name, u.last_name, u.phone, s.rating, s.avatar, rt1.status, pt.name as package_type'
                . ' FROM users u'
                . ' JOIN shippers s ON (u.id = s.user_id)'
                . ' JOIN trips t ON (t.shipper_id = s.id)'
                . ' JOIN request_ships rs ON (t.request_ship_id = rs.id)'
                . ' JOIN package_types pt ON (rs.package_type_id = pt.id)'
                . ' JOIN request_trackings rt1 ON (rs.id = rt1.request_ship_id)'
                . ' LEFT OUTER JOIN request_trackings rt2'
                . ' ON (rs.id = rt2.request_ship_id AND'
                . ' (rt1.changed_at < rt2.changed_at OR rt1.changed_at = rt2.changed_at AND rt1.id < rt2.id))'
                . ' WHERE rt2.id IS NULL AND rs.user_id = :user_id AND rs.id = :id';
        } else {
            $sql = 'SELECT rs.*, rt1.status, pt.name as package_type'
                . ' FROM request_ships rs'
                . ' JOIN package_types pt ON (rs.package_type_id = pt.id)'
                . ' JOIN request_trackings rt1 ON (rs.id = rt1.request_ship_id)'
                . ' LEFT OUTER JOIN request_trackings rt2'
                . ' ON (rs.id = rt2.request_ship_id AND'
                . ' (rt1.changed_at < rt2.changed_at OR rt1.changed_at = rt2.changed_at AND rt1.id < rt2.id))'
                . ' WHERE rt2.id IS NULL AND rs.user_id = :user_id AND rs.id = :id';
        }


        $record = DB::select($sql, ['user_id' => $packageOwnerId, 'id' => $requestShipId]);

        if (!empty($record)) {
            $record[0]->is_picked = $isPicked;
            $record = $record[0];
        }

        return $record;
    }
}

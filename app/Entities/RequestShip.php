<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @SWG\Definition(
 *     definition="NewRequestShip",
 *     required={
 *          "user_id",
 *          "package_type_id",
 *          "promo_code_id",
 *          "receiver_name",
 *          "receiver_phone",
 *          "pickup_location",
 *          "pickup_location_address",
 *          "destination",
 *          "destination_address",
 *          "price",
 *          "distance",
 *          "duration",
 *          "size",
 *     },
 *     @SWG\Property(
 *          property="user_id",
 *          type="integer",
 *          description="Package owner ID",
 *          example="1"
 *    ),
 *     @SWG\Property(
 *          property="package_type_id",
 *          type="integer",
 *          description="Package type ID",
 *          example="1"
 *    ),
 *     @SWG\Property(
 *          property="promo_code_id",
 *          type="integer",
 *          description="Promo code ID",
 *          example="1"
 *    ),
 *     @SWG\Property(
 *          property="receiver_name",
 *          type="string",
 *          description="Receiver's Name",
 *          example="John Smith"
 *    ),
 *     @SWG\Property(
 *          property="receiver_phone",
 *          type="string",
 *          description="Receiver's Phone",
 *          example="0981545454"
 *    ),
 *     @SWG\Property(
 *          property="pickup_location",
 *          type="string",
 *          format="json",
 *          description="Pick up location",
 *          example="{latitude:16.231231231, longitude:102.1231231}"
 *    ),
 *    @SWG\Property(
 *          property="pickup_location_address",
 *          type="string",
 *          description="Package's Pick up location address",
 *          example="453 Hoang Dieu, Hai Chau, Danang"
 *    ),
 *     @SWG\Property(
 *          property="destination",
 *          type="string",
 *          format="json",
 *          description="Package's Destination",
 *          example="{latitude:16.41231231, longitude:102.1231231}"
 *    ),
 *     @SWG\Property(
 *          property="destination_address",
 *          type="string",
 *          description="Pick up location address",
 *          example="23 Trung Nu Vuong, Hai Chau, Danang"
 *    ),
 *     @SWG\Property(
 *          property="price",
 *          type="float",
 *          description="Package Fare",
 *          example="20000"
 *    ),
 *     @SWG\Property(
 *          property="distance",
 *          type="string",
 *          description="Distance between pickup location and destination (km)",
 *          example="3.3"
 *    ),
 *     @SWG\Property(
 *          property="duration",
 *          type="integer",
 *          description="Duration between pickup location and destination (s)",
 *          example="600"
 *    ),
 *     @SWG\Property(
 *          property="size",
 *          type="string",
 *          format="json",
 *          description="Package's size",
 *          example="{length: 15, width: 20, height: 15}"
 *    ),
 *     @SWG\Property(
 *          property="note",
 *          type="string",
 *          description="Detail information for package",
 *          example="String"
 *    )
 * )
 * @SWG\Definition(
 *     definition="RequestShip",
 *     allOf = {
 *          { "$ref": "#/definitions/NewRequestShip" },
 *          { "$ref": "#/definitions/Timestamps" },
 *          { "required": {"id"} }
 *     }
 * )
 */

class RequestShip extends Model
{
    const UNVERIFIED_PO_CODE = 0;
    const VERIFIED_PO_CODE = 1;
    const UNVERIFIED_RECEIVER_CODE = 0;
    const VERIFIED_RECEIVER_CODE = 1;
    const UNVERIFIED_OTP = 0;
    const VERIFIED_OTP = 1;

    protected $fillable = [
        'user_id',
        'package_type_id',
        'promo_code_id',
        'receiver_name',
        'receiver_phone',
        'pickup_location',
        'pickup_location_address',
        'destination',
        'destination_address',
        'price',
        'distance',
        'duration',
        'size',
        'note',
        'po_verification_code',
        'verified_po_code',
        'receiver_verification_code',
        'verified_receiver_code',
    ];
    // Defining An Accessor
//    public function getPickupLocationAttribute($value)
//    {
//        return json_decode($value, true);
//    }
//
//    public function getDestinationAttribute($value)
//    {
//        return json_decode($value, true);
//    }
    // Utility function
    public function isVerifiedPOCode()
    {
        return $this->verified_po_code == RequestShip::VERIFIED_PO_CODE;
    }

    public function isVerifiedReceiverCode()
    {
        return $this->verified_receiver_code == RequestShip::VERIFIED_RECEIVER_CODE;
    }

    public function isVerifiedOTP()
    {
        return $this->verified_otp == RequestShip::VERIFIED_OTP;
    }

    public function getCoordinateFromPickupLocation()
    {
        $coordinateArray = json_decode($this->pickup_location, true);
        return $coordinateArray;
    }

    public function getCoordinateFromDestination()
    {
        $coordinateArray = json_decode($this->destination, true);
        return $coordinateArray;
    }

    // Relationship
    public function packageType()
    {
        return $this->belongsTo('App\Entities\PackageType');
    }

    public function promoCode()
    {
        return $this->belongsTo('App\Entities\PromoCode');
    }

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function trip()
    {
        return $this->hasOne('App\Entities\Trip');
    }

    public function requestTrackings()
    {
        return $this->hasMany('App\Entities\RequestTracking');
    }

    //
    public static function getRequestShipList()
    {
        $records = DB::select(
            'SELECT rs.id, rs.created_at, rs.pickup_location_address, rs.destination_address, rt1.status, rs.price, u.first_name, u.last_name, pt.name, t.shipper_id'
            . ' FROM request_ships rs'
            . ' LEFT JOIN trips t ON (t.request_ship_id = rs.id)'
            . ' JOIN users u ON (u.id = rs.user_id)'
            . ' JOIN package_types pt ON (pt.id = rs.package_type_id)'
            . ' JOIN request_trackings rt1 ON (rs.id = rt1.request_ship_id)'
            . ' LEFT OUTER JOIN request_trackings rt2 ON (rs.id = rt2.request_ship_id AND'
            . ' (rt1.changed_at < rt2.changed_at OR rt1.changed_at = rt2.changed_at AND rt1.id < rt2.id))'
            . ' WHERE rt2.id IS NULL'
        );

        return $records;
    }

    //
    public static function randomCode()
    {
        $code = '';
        for ($i = 0; $i<4; $i++)
        {
            $code .= mt_rand(0,9);
        }
        return $code;
    }
}

<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *     definition="NewTrip",
 *     required={
 *          "request_ship_id",
 *          "shipper_id",
 *          "pickup_time",
 *          "dropoff_time",
 *          "package_owner_rating",
 *          "receiver_rating",
 *          "shipper_rating",
 *     },
 *     @SWG\Property(
 *          property="request_ship_id",
 *          type="integer",
 *          description="Request Ship ID",
 *          example="1"
 *    ),
 *     @SWG\Property(
 *          property="shipper_id",
 *          type="integer",
 *          description="Shipper ID",
 *          example="1"
 *    ),
 *     @SWG\Property(
 *          property="pickup_time",
 *          type="string",
 *          format="date-time",
 *          description="Pickup time",
 *          example="2018-03-13 02:39:03"
 *    ),
 *     @SWG\Property(
 *          property="dropoff_time",
 *          type="string",
 *          format="date-time",
 *          description="Drop off time",
 *          example="2018-03-13 02:39:03"
 *    ),
 *     @SWG\Property(
 *          property="package_owner_rating",
 *          type="double",
 *          description="Package owner rating",
 *          example="5.0"
 *    ),
 *     @SWG\Property(
 *          property="receiver_rating",
 *          type="double",
 *          description="Receiver rating",
 *          example="4.3"
 *    ),
 *    @SWG\Property(
 *          property="shipper_rating",
 *          type="double",
 *          description="Shipper rating",
 *          example="4.5"
 *    )
 * )
 * @SWG\Definition(
 *     definition="Trip",
 *     allOf = {
 *          { "$ref": "#/definitions/NewTrip" },
 *          { "$ref": "#/definitions/Timestamps" },
 *          { "required": {"id"} }
 *     }
 * )
 */

class Trip extends Model
{
    protected $fillable = [
        'request_ship_id',
        'shipper_id',
        'pickup_time',
        'dropoff_time',
        'package_owner_rating',
        'receiver_rating',
        'shipper_rating',
    ];

    // Relationships
    public function shipper()
    {
        return $this->belongsTo('App\Entities\Shipper');
    }

    public function requestShip()
    {
        return $this->belongsTo('App\Entities\RequestShip');
    }
}

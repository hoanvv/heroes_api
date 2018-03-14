<?php
/**
 * Created by PhpStorm.
 * User: harley
 * Date: 3/14/18
 * Time: 11:37 AM
 */

namespace App\Traits;


use App\Entities\RequestTracking;
use Carbon\Carbon;

trait UpdateRequestTracking
{
    /**
     * Update status of request ship.
     *
     * @param $userId
     * @param $requestShipId
     * @param $status
     * @return void
     */
    protected function updateRequestTracking($userId, $requestShipId, $status)
    {
        // Prepare data for request tracking before insert
        $data['user_id'] = $userId;
        $data['request_ship_id'] = $requestShipId;
        $data['status'] = $status;
        $data['changed_at'] = Carbon::now();

        $result = RequestTracking::create($data);
    }
}
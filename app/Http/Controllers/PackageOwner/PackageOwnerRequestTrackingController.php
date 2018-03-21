<?php

namespace App\Http\Controllers\PackageOwner;

use App\Entities\RequestTracking;
use App\Http\Controllers\ApiController;
use App\Traits\FirebaseConnection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageOwnerRequestTrackingController extends ApiController
{
    use FirebaseConnection;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'request_ship_id' => 'required|integer',
            'status' => 'required|integer|between:0,5'
        ];

        $this->validate($request, $rules);

        // Prepare data for request tracking before insert
        $requestTrackingData['user_id'] = Auth::user()->id;
        $requestTrackingData['request_ship_id'] = $request->input('request_ship_id');
        $requestTrackingData['status'] = $request->input('status');
        $requestTrackingData['changed_at'] = Carbon::now();
        // Insert data for request tracking into database
        $requestTracking = RequestTracking::create($requestTrackingData);
        // Insert data for request package into firebase
        switch ($requestTrackingData['status']) {
            case RequestTracking::CANCELLED_REQUEST:

                break;

            case RequestTracking::CONFIRMED_TRIP:

                break;
        }
        $path = "package/package-owner/{$requestShip->user_id}/pickup/{$requestShip->user_id}";

        $pickup_location = $requestShip->only('pickup_location');
        $data = json_decode($pickup_location['pickup_location'], true);
        $extraData = $requestShip->only(['distance', 'destination_address', 'price', 'id']);
        $data = array_merge($data, $extraData);

        $status = ['status' => $requestTracking->status];

        $data = array_merge($data, $status);

        $this->saveData($path, $data);

        $requestShip->save();

        return $this->showOne($requestShip);
    }
}

<?php

namespace App\Http\Controllers\PackageOwner;

use App\Entities\PackageOwner;
use App\Entities\RequestShip;
use App\Entities\RequestTracking;
use App\Entities\Shipper;
use App\Entities\Trip;
use App\Http\Controllers\ApiController;
use App\Traits\FirebaseConnection;
use App\Traits\SMSTrait;
use App\Traits\UpdateRequestTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageOwnerTripController extends ApiController
{
    use UpdateRequestTracking;
    use SMSTrait;
    use FirebaseConnection;

    public function index()
    {
        $userId = Auth::user()->id;
        $data = PackageOwner::getRequestShipList($userId);
        return response()->json(['data' => $data]);

    }

    public function show($id)
    {
        $userId = Auth::user()->id;
        $trip = Trip::where('request_ship_id', $id)->first();

        if ($trip === null) {
            $data = PackageOwner::getRequestShip($userId, $id, false);
        } else {
            $data = PackageOwner::getRequestShip($userId, $id, true);
        }

        return response()->json(['data' => $data], 200);

    }

    public function update(Request $request, $requestShipId)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //validate
        $requestShip = RequestShip::getRequestShip($id);
        if (empty($requestShip)) {
            $message = array(
                'success' => false,
                'message' => "Not found",
                'code' => 404
            );
            $status = 404;
            return response()->json($message, $status);
        }

        if ($requestShip->status >= RequestTracking::DELIVERING_TRIP) {
            $message = array(
                'success' => false,
                'message' => "Your package is delivering. You cannot cancel it. Let's contact with shipper",
                'code' => 403
            );
            $status = 403;
            return response()->json($message, $status);
        }


        //Update
        $user = Auth::user();

        if ($requestShip->user_id != $user->id) {
            $message = array(
                'success' => false,
                'message' => "You are cheating",
                'code' => 403
            );
            $status = 403;
            return response()->json($message, $status);
        }
        $status = RequestTracking::CANCELLED_REQUEST;
        $this->updateRequestTracking($user->id, $id, $status);

        if ($requestShip->status == RequestTracking::WAITING_REQUEST) {
            $path = "request-ship/{$requestShip->id}";
            $this->deleteData($path);
            $path = "package-owner/{$requestShip->user_id}/request-ship/{$requestShip->id}/status";
            $status = RequestTracking::CANCELLED_REQUEST;
            $this->saveData($path, $status);
        }

        if ($requestShip->status == RequestTracking::ACCEPTED_REQUEST) {
            $path = "package-owner/{$requestShip->user_id}/request-ship/{$requestShip->id}/status";
            $status = RequestTracking::CANCELLED_REQUEST;
            $this->saveData($path, $status);

            $path = "shipper/{$requestShip->shipper_id}/request-ship/{$requestShip->id}";
            $this->deleteData($path);

            $path = "shipper/{$requestShip->shipper_id}/notification/{$requestShip->id}";
            $data['id'] = $requestShip->id;
            $data['pickup_location_address'] = $requestShip->pickup_location_address;
            $data['destination_address'] = $requestShip->destination_address;
            $data['status'] = 0;
            $this->saveData($path, $data);
        }
        //Return
        $message = array(
            'success' => true,
            'message' => "Your request has been cancelled. Thank you for using our service",
            'code' => 200
        );
        $status = 200;
        return response()->json($message, $status);
    }

    public function sendRequestToDefaultShipper(Request $request)
    {
        $rules = [
            'request_ship_id' => 'required|integer'
        ];

        $this->validate($request, $rules);

        // Setup model data
        $dataTrip = $request->all();
        $packageOwner = Auth::user()->first();
        $requestShip = RequestShip::getRequestShip($dataTrip['request_ship_id']);

        //validate
        if ($requestShip->status != RequestTracking::WAITING_REQUEST) {
            $message = array(
                'success' => false,
                'message' => "You cannot use this feature",
                'code' => 403
            );
            $status = 403;
            return response()->json($message, $status);
        }
        $shipper = Shipper::where([
            ['is_online', Shipper::ONLINE_SHIP],
            ['is_default', Shipper::STATUS_DEFAULT_SHIPPER]
        ])->inRandomOrder()->first();

        $dataTrip['shipper_id'] = $shipper->id;

        // Insert data for trip into database
        $trip = Trip::create($dataTrip);

        // update status of request tracking
        $status = RequestTracking::ACCEPTED_REQUEST;
        $requestShipId = $dataTrip['request_ship_id'];
        $shipperId = $dataTrip['shipper_id'];
        $this->updateRequestTracking($shipperId, $requestShipId, $status);

        // Retrieve this request ship from package/available/{$requestShipId}
        $path = 'request-ship/' . $requestShipId;
        $availablePackage = $this->retrieveData($path);
        $availablePackage['status'] = $status;

        // Remove this request ship from package/available/{$requestShipId}
        $this->deleteData($path);
        // Insert this request ship into shipper/{shipper_id}/request-ship
        $path = "shipper/{$shipperId}/request-ship/{$requestShipId}";
        $this->saveData($path, $availablePackage);
        // Insert this request ship into package/package-owner/{package_owner_id}
        $path = "package-owner/{$packageOwner->id}/request-ship/{$requestShipId}/status";
        $this->saveData($path, $status);

        $path = "shipper/{$shipperId}/notification/{$requestShipId}";
        $availablePackage['shipper_id'] = $shipperId;
        $this->saveData($path, $availablePackage);

        $message = array(
            'success' => true,
            'message' => "Your order just move to our shipper",
            'code' => 200
        );
        return response()->json($message, 200);
    }
}

<?php

namespace App\Http\Controllers\Shipper;

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
use Illuminate\Support\Facades\DB;

class ShipperTripController extends ApiController
{
    use UpdateRequestTracking;
    use FirebaseConnection;
    use SMSTrait;

    public function index()
    {
        $shipperId = Auth::user()->shipper()->first()->id;
        $data = Shipper::getRequestShipList($shipperId);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Post(
     *     path="/trips",
     *     tags={"Trips"},
     *     summary="Choose a request ship for delivering",
     *     @SWG\Parameter(
     * 			name="id",
     * 			in="body",
     *          @SWG\Schema(
     *              required={"request_ship_id", "authentication_token"},
     *              @SWG\Property(property="request_ship_id",  type="integer"),
     *              @SWG\Property(property="authentication_token",  type="string")
     *          ),
     * 			required=true,
     * 			type="integer",
     * 			description="ID",
     * 		),
     *     @SWG\Response(
     *          response=201,
     *          description="A newly-created trip",
     *          @SWG\Schema(ref="#/definitions/Trip")
     *      ),
     *     @SWG\Response(
     *          response="default",
     *          description="error",
     *          @SWG\Schema(ref="#/definitions/Error")
     *   )
     * ),
     */

    public function store(Request $request)
    {
        $rules = [
            'request_ship_id' => 'required|integer'
        ];

        $this->validate($request, $rules);

        // Prepare data for trip before insert
        $tripData = $request->all();
        $tripData['shipper_id'] = Auth::user()->shipper()->first()->id;

        // Insert data for trip into database
        $trip = Trip::create($tripData);

        // update status of request tracking
        $status = RequestTracking::ACCEPTED_REQUEST;
        $requestShipId = $tripData['request_ship_id'];
        $shipperId = $tripData['shipper_id'];
        $this->updateRequestTracking($shipperId, $requestShipId, $status);

        // Retrieve this request ship from package/available/{$requestShipId}
        $path = 'package/available/' . $requestShipId;
        $availablePackage = $this->retrieveData($path);
        $availablePackage['status'] = $status;

        $availablePackage['status'] = $status;

        // Remove this request ship from package/available/{$requestShipId}
        $this->deleteData($path);

        // Insert this request ship into package/shipper/{shipper_id}
        $path = "package/shipper/{$shipperId}/{$requestShipId}";
        $this->saveData($path, $availablePackage);
        // Insert this request ship into package/package-owner/{package_owner_id}
        $packageOwner = RequestShip::findOrFail($requestShipId)->user()->first();
        $packageOwnerId = $packageOwner->id;
        $packageOwnerPhone = $packageOwner->phone;

        $path = "package/package-owner/{$packageOwnerId}/{$requestShipId}";
        $availablePackage['shipper_id'] = $shipperId;
        $this->saveData($path, $availablePackage);

        // Return pickup location and destination for showing the route on map
        $data = RequestShip::findOrFail($requestShipId)->only(['pickup_location', 'destination']);
        $array = array_values($data);
        $arrayTemp = [];
        foreach($array as $item) {
            $json_array = json_decode($item, true);
            array_push($arrayTemp, $json_array);
        }

        return response()->json(['data' => $arrayTemp], 200);

    }

    public function show($id)
    {
        $shipperId = Auth::user()->shipper()->first()->id;
        $data = Shipper::getRequestShip($shipperId, $id);

        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $requestShipId)
    {
        $rules = [
            'po_verification_code' => 'required|string',
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $requestShip = RequestShip::findOrFail($requestShipId);
        $requestShipOwner = $requestShip->user()->first();

        // Check verified package owner code before verifying OTP code
        if ($requestShip->isVerifiedPOCode()) {
            $message = array(
                'success' => false,
                'message' => "This code was verified",
                'code' => 403
            );
            return response()->json($message, 403);
        }

        // Verify code sent
        if ($requestShip['po_verification_code'] != $data['po_verification_code']) {
            $message = array(
                'success' => false,
                'message' => "Package owner verification code didnt match",
                'code' => 401
            );
            $status = 401;
        } else {
            // Send OTP code to package owner
            $PoPhone = $requestShipOwner->phone;
            $response = $this->sendVerifySMS($PoPhone);
            $responseObject = json_decode($response);
            if (!$responseObject->success) {
                $message = array(
                    'success' => false,
                    'message' => $responseObject->message,
                    'code' => 403
                );
                return response()->json($message, 403);
            }

            // Update status of po verification code
            $requestShip->verified_po_code = RequestShip::VERIFIED_PO_CODE;
            $requestShip->save();

            $message = array(
                'success' => true,
                'message' => 'Package owner verification code was verified. Please wait Package owner to confirm again.',
                'code' => 200
            );
            $status = 200;

        }
        return response()->json($message, $status);
    }
}

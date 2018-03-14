<?php

namespace App\Http\Controllers\Trip;

use App\Entities\RequestShip;
use App\Entities\RequestTracking;
use App\Entities\Trip;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Traits\UpdateRequestTracking;
use App\Traits\FirebaseConnection;

class TripController extends ApiController
{
    use UpdateRequestTracking;
    use FirebaseConnection;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'authentication_token' => 'required|string',
            'request_ship_id' => 'required|integer',
        ];

        $this->validate($request, $rules);

        // Prepare data for trip before insert
        $tripData = $request->all();
        $tripData['shipper_id'] = 6;

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

        // Remove this request ship from package/available/{$requestShipId}
        $this->deleteData($path);

        // Insert this request ship into package/shipper/{shipper_id}
        $path = "package/shipper/{$shipperId}/{$requestShipId}";
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

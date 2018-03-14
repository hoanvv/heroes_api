<?php

namespace App\Http\Controllers\RequestShip;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

use App\Entities\RequestShip;
use App\Entities\RequestTracking;
use App\Traits\FirebaseConnection;

class RequestShipController extends ApiController
{
    use FirebaseConnection;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requestShips = RequestShip::all();

        return $this->showAll($requestShips);
    }
    /**
     * @SWG\Post(
     *     path="/requestShips",
     *     tags={"Request Ship"},
     *     summary="Create new request ship",
     *     @SWG\Parameter(
     * 			name="id",
     * 			in="body",
     *          schema={"$ref": "#/definitions/NewRequestShip"},
     * 			required=true,
     * 			type="integer",
     * 			description="ID",
     * 		),
     *     @SWG\Response(
     *          response=201,
     *          description="A newly-created request ship",
     *          @SWG\Schema(ref="#/definitions/RequestShip")
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
            'package_type_id' => 'required|integer',
            'promo_code_id' => 'required|integer',
            'receiver_name' => 'required|string|max:100',
            'receiver_phone' => 'required|string|max:20',
            'pickup_location' => 'required|string|json',
            'pickup_location_address' => 'required|string',
            'destination' => 'required|string|json',
            'destination_address' => 'required|string',
            'distance' => 'required|numeric',
            'duration' => 'required|integer',
            'size' => 'string|json',
            'note' => 'string',
            'price' => 'required|numeric'
        ];

        $this->validate($request, $rules);

        // Prepare data for request ship before insert
        $requestShipData = $request->all();
        $requestShipData['user_id'] = 5;
        $requestShipData['distance'] /= 1000;
        // Insert data for request ship into database
        $requestShip = RequestShip::create($requestShipData);

        // Prepare data for request tracking before insert
        $requestTrackingData['user_id'] = 7;
        $requestTrackingData['request_ship_id'] = $requestShip->id;
        $requestTrackingData['status'] = RequestTracking::WAITING_REQUEST;
        $requestTrackingData['changed_at'] = $requestShip->created_at;
        // Insert data for request tracking into database
        $requestTracking = RequestTracking::create($requestTrackingData);
        // Insert data for request package into firebase
        $path = "package/available/{$requestShip->id}";

        $pickup_location = $requestShip->only('pickup_location');
        $data = json_decode($pickup_location['pickup_location'], true);
        $extraData = $requestShip->only(['distance', 'destination_address', 'price']);
        $data = array_merge($data, $extraData);

        $this->saveData($path, $data);

        return $this->showOne($requestShip, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param RequestShip $requestShip
     * @return void
     */
    /**
     * @SWG\Get(
     *     path="/requestShip/{id}",
     *     tags={"Request Ship"},
     *     summary="Fetch request ship",
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          description="ID",
     * 		),
     *     @SWG\Response(
     *          response=200,
     *          description="An employee",
     *          @SWG\Schema(ref="#/definitions/NewRequestShip")
     *      ),
     *     @SWG\Response(
     *          response="default",
     *          description="error",
     *          @SWG\Schema(ref="#/definitions/Error")
     *   )
     * ),
     */
    public function show($id)
    {
        $detail = RequestShip::with(['user', 'packageType'])->findOrFail($id);
        return $this->showOne($detail);
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
//
//    public function getPackageFare(Request $request)
//    {
//        $rules = [
//            'package_type_id' => 'required|integer',
//            'size' => 'string|json',
//            'distance' => 'required|numeric',
//            'duration' => 'required|integer'
//        ];
//
//        $this->validate($request, $rules);
//
//        $data = $request->all();
//
//        $packageType = PackageType::findOrFail($data['package_type_id']);
//
//        if ($packageType->isOptional() && $request->has('size')) {
//            $size = json_decode($data['size']);
//            $packageTypePrice = $this->calculateWeightPriceFromVolumetricWeight(
//                $size->length,
//                $size->width,
//                $size->height,
//                $packageType
//            );
//        } else {
//            $packageTypePrice = $packageType->price;
//        }
//        // Convert units
//        $data['distance'] /= 1000; // from meter to kilometer
//        $data['duration'] /= 60; // from second to minute
//
//        $price = $this->calculateFare(
//            $data['distance'],
//            $data['duration'],
//            $packageTypePrice
//        );
//
//        return response()->json(['price' => $price], 200);
//    }
}

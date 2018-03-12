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
     * @OAS\Post(
     *     path="/requestShips",
     *     tags={"RequestShips"},
     *     summary="Register a package to delivery",
     *     operationId="store",
     *     @OAS\Parameter(
     *           "promo_code_id": "1",
     *           "receiver_name": "Vo Van Hoang",
     *           "receiver_phone": "068798798789",
     *           "pickup_location": "{\"latitude\":16.231231231, \"longitude\":102.1231231}",
     *           "destination": "{\"latitude\":16.231231231, \"longitude\":102.1231231}",
     *           "distance": "3.3",
     *           "duration": "180",
     *           "package_type_id": "1",
     *           "user_id": 5,
     *           "note": "Register a package",
     *           "authentication_token": "WERTERWTSDFGVC234ASDFRA2TD634",
     *           "price": 20000
     *     ),
     *     @OAS\Response(
     *         "data": {
     *               "promo_code_id": "1",
     *               "receiver_name": "Vo Van Hoang",
     *               "receiver_phone": "068798798789",
     *               "pickup_location": "{\"latitude\":16.231231231, \"longitude\":102.1231231}",
     *               "destination": "{\"latitude\":16.231231231, \"longitude\":102.1231231}",
     *               "distance": 0.0033,
     *               "duration": "180",
     *               "package_type_id": "1",
     *               "user_id": 5,
     *               "note": "asdfasdfasdfas",
     *               "price": 20000,
     *               "updated_at": "2018-03-11 15:13:12",
     *               "created_at": "2018-03-11 15:13:12",
     *               "id": 1
     *           }
     *     )
     * )
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
            'destination' => 'required|string|json',
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
        $firebase = (new Factory())
            ->withServiceAccount($this->registerService())
            ->create();
        $db = $firebase->getDatabase();

        $pickup_location = $requestShip->only('pickup_location');
        $coordinate = json_decode($pickup_location['pickup_location'], true);

        $db->getReference("package/available/{$requestShip->id}")
            ->set($coordinate);

        return $this->showOne($requestShip, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param RequestShip $requestShip
     * @return void
     */
    public function show(RequestShip $requestShip)
    {
        $detail = $requestShip->with(['user', 'packageType'])->first();
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

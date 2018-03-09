<?php

namespace App\Http\Controllers\RequestShip;

use App\Entities\PackageWeight;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Entities\Shipper;
use App\Entities\RequestShip;
use App\Entities\RequestTracking;
use App\Traits\CalculateFare;

class RequestShipController extends ApiController
{
    use CalculateFare;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'authentication_token' => 'required|string',
            'package_weight_id' => 'required|integer',
            'promo_code_id' => 'required|integer',
            'receiver_name' => 'required|string|max:100',
            'receiver_phone' => 'required|string|max:20',
            'pickup_location' => 'required|string|json',
            'destination' => 'required|string|json',
            'distance' => 'required|numeric',
            'duration' => 'required|integer',
            'size' => 'required|string|json',
            'note' => 'string',
            'price' => 'required|numeric'
        ];

        $this->validate($request, $rules);
        // Prepare data for request ship before insert
        $requestShipData = $request->all();
        $requestShipData['user_id'] = 5;

        $requestShip = RequestShip::create($requestShipData);
        // Prepare data for request tracking before insert
        $requestTrackingData['user_id'] = 7;
        $requestTrackingData['request_ship_id'] = $requestShip->id;
        $requestTrackingData['status'] = RequestTracking::WAITING_REQUEST;
        $requestTrackingData['changed_at'] = $requestShip->created_at;

        $requestTracking = RequestTracking::create($requestTrackingData);

        return $this->showOne($requestShip, 201);
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        //
//    }

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

    public function getPackageFare(Request $request)
    {
        $rules = [
            'package_weight_id' => 'required|integer',
            'size' => 'required|string|json',
            'distance' => 'required|numeric',
            'duration' => 'required|integer'
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $size = json_decode($data['size']);
        $volumetricWeight = $this->calculateVolumetricWeight(
            $size->length,
            $size->width,
            $size->height
        );

        $packageWeight = PackageWeight::findOrFail($data['package_weight_id']);

        $price = $this->calculateFare(
            $data['distance'],
            $data['duration'],
            $volumetricWeight,
            $packageWeight
        );

        echo $price;
    }
}

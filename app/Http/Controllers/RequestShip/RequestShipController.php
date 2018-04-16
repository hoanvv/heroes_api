<?php

namespace App\Http\Controllers\RequestShip;

use App\Http\Controllers\ApiController;
use App\Jobs\PushNotificationToShipper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * Register the package
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @SWG\Post(
     *     path="/api/requestShips",
     *     tags={"Request Ship"},
     *     summary="Create new request ship",
     *     @SWG\Parameter(
     *            name="id",
     *            in="body",
     *          schema={"$ref": "#/definitions/NewRequestShip"},
     *            required=true,
     *            type="integer",
     *            description="ID",
     *        ),
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
        $requestShipData['user_id'] = Auth::user()->id;
        $requestShipData['distance'] /= 1000;

        $requestShipData['po_verification_code'] = RequestShip::randomCode();
        $requestShipData['receiver_verification_code'] = RequestShip::randomCode();
        // Insert data for request ship into database
        $requestShip = RequestShip::create($requestShipData);

        // Prepare data for request tracking before insert
        $requestTrackingData['user_id'] = Auth::user()->id;
        $requestTrackingData['request_ship_id'] = $requestShip->id;
        $requestTrackingData['status'] = RequestTracking::WAITING_REQUEST;
        $requestTrackingData['changed_at'] = $requestShip->created_at;
        // Insert data for request tracking into database
        $requestTracking = RequestTracking::create($requestTrackingData);
        // Insert data for request package into firebase
        $path = "package-owner/{$requestShip->user_id}/request-ship/{$requestShip->id}";

        $pickup_location = $requestShip->pickup_location;
        $pickup_location_array = json_decode($pickup_location, true);
        $pickup_location_array['pickup_latitude'] = $pickup_location_array['latitude'];
        unset($pickup_location_array['latitude']);
        $pickup_location_array['pickup_longitude'] = $pickup_location_array['longitude'];
        unset($pickup_location_array['longitude']);

        $destination = $requestShip->destination;
        $destination_array = json_decode($destination, true);
        $destination_array['destination_latitude'] = $destination_array['latitude'];
        unset($destination_array['latitude']);
        $destination_array['destination_longitude'] = $destination_array['longitude'];
        unset($destination_array['longitude']);

        $extraData = $requestShip->only([
            'distance',
            'destination_address',
            'pickup_location_address',
            'price',
            'id',
            'size'
        ]);
        if ($extraData['size']) {
            $extraData['size'] = json_decode($extraData['size'], true);
        }
        $extraData['package_type'] = $requestShip->packageType()->first()->name;

        $states = [
            'status' => $requestTracking->status,
            'is_shown' => 1
        ];
        $data = array_merge($pickup_location_array, $destination_array, $extraData, $states);

        $this->saveData($path, $data);

        $path1 = "request-ship/{$requestShip->id}";
        $this->saveData($path1, $data);

        PushNotificationToShipper::dispatch($data);

        return $this->showOne($requestShip, 202);
    }

    /**
     * Display the specified resource.
     *
     * @param RequestShip $requestShip
     * @return void
     */
    /**
     * @SWG\Get(
     *     path="/api/requestShip/{id}",
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

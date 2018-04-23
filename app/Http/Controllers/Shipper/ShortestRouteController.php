<?php

namespace App\Http\Controllers\Shipper;

use App\Entities\RequestTracking;
use App\Entities\Shipper;
use App\Http\Controllers\ApiController;
use App\Traits\FirebaseConnection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\RoutingSearchService;

class ShortestRouteController extends ApiController
{
    use FirebaseConnection;

    public function __construct()
    {
        $this->middleware('online');
    }
    //
    public function index(Request $request)
    {
        $positions = [];
        $checked = [];

        if ($request->has('destination')) {
            $input = $request->input('destination');
            if ($this->isJson($input)) {
                $destinationPosition = json_decode($input, true);
                $destinationPosition['request_ship_id'] = 99;
                $checked[99] = 1;
            } else {
                $message = "The field destination must be a json string";
                return $this->errorResponse($message, 422);
            }
        } else {
            $destinationPosition = null;
        }

        $shipper = Auth::user()->shipper()->first();

        $currentPosition = [
            'latitude' => $shipper->latitude,
            'longitude' => $shipper->longitude,
            'request_ship_id' => 0
        ];

        $requestPositions = Shipper::getNotCompletedRequestShipList($shipper->id);

        array_push($positions, $currentPosition);
        $pairPos[0] = 0;
        $i = 1;

        foreach ($requestPositions as $item) {
            $checked[$item->id] = 0;
            if ($item->status == RequestTracking::ACCEPTED_REQUEST) {
                $pairPos[$i++] = 1;
                $pairPos[$i++] = 1;
                $pickupLocation = json_decode($item->pickup_location, true);
                $pickupLocation['request_ship_id'] = $item->id;
                $destination = json_decode($item->destination, true);
                $destination['request_ship_id'] = $item->id;
                array_push($positions, $pickupLocation, $destination);
            } elseif ($item->status == RequestTracking::DELIVERING_TRIP) {
                $pairPos[$i++] = 0;
                $destination = json_decode($item->destination, true);
                $destination['request_ship_id'] = $item->id;
                array_push($positions, $destination);
            } else {

            }
        }

        $routingSearch = new RoutingSearchService($positions, $pairPos, $destinationPosition);
//        dd($routingSearch->getBestRoute());

        $data = [];
        array_push($positions, $destinationPosition);

        foreach ($routingSearch->getBestRoute() as $key => $pos) {
            $temp =  $positions[$pos]['latitude'] . ',' . $positions[$pos]['longitude'];
            array_push($data, $temp);

            $requestShipId = $positions[$pos]['request_ship_id'];
            if ($pos != 0 && $checked[$requestShipId] == 0 && $requestShipId != 99) {
                $path = "shipper/{$shipper->id}/request-ship/{$requestShipId}/order_by";
                $this->saveData($path, $key);
                $checked[$requestShipId] = 1;
            }
        }
        return response()->json(['data' => $data], 200);

    }

    private function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

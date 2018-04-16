<?php

namespace App\Http\Controllers\Shipper;

use App\Entities\RequestTracking;
use App\Entities\Shipper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\RoutingSearchService;

class ShortestRouteController extends Controller
{
    public function __construct()
    {
        $this->middleware('online');
    }
    //
    public function index()
    {
        $shipper = Auth::user()->shipper()->first();

        $currentPosition = [
            'latitude' => $shipper->latitude,
            'longitude' => $shipper->longitude
        ];

        $requestPositions = Shipper::getNotCompletedRequestShipList($shipper->id);

        $positions = [];
        $check = [];
        array_push($positions, $currentPosition);
        $pairPos[0] = 0;
        $i = 1;
        foreach ($requestPositions as $item) {
//            $pickupLocation = json_decode($item->pickup_location, true);
//            $destination = json_decode($item->destination, true);
//            array_push($positions, $pickupLocation, $destination);
            if ($item->status == RequestTracking::ACCEPTED_REQUEST) {
                $pairPos[$i++] = 1;
                $pairPos[$i++] = 1;
                $pickupLocation = json_decode($item->pickup_location, true);
                $destination = json_decode($item->destination, true);
                array_push($positions, $pickupLocation, $destination);
            } elseif ($item->status == RequestTracking::DELIVERING_TRIP) {
                $pairPos[$i++] = 0;
                $destination = json_decode($item->destination, true);
                array_push($positions, $destination);
            } else {

            }
        }

        $routingSearch = new RoutingSearchService($positions, $pairPos);

        $data = [];
        foreach ($routingSearch->getBestRoute() as $pos) {
            $temp =  $positions[$pos]['latitude'] . ',' . $positions[$pos]['longitude'];
            array_push($data, $temp);
        }
        return response()->json(['data' => $data], 200);

    }
}

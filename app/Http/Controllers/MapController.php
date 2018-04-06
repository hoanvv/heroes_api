<?php

namespace App\Http\Controllers;

use App\Entities\RequestShip;
use App\Traits\DistanceMatrixServiceCustom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ivory\GoogleMap\Service\DistanceMatrix\DistanceMatrixService;
use Http\Adapter\Guzzle6\Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Service\DistanceMatrix\Request\DistanceMatrixRequest;
use Ivory\GoogleMap\Service\Base\TravelMode;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Service\Base\Location\CoordinateLocation;
use App\Services\RoutingSearchService;

class MapController extends Controller
{
    use DistanceMatrixServiceCustom;

    public function index()
    {

        // 16.065606, 108.197075
        // 16.059915, 108.211108
        // 16.068534, 108.220421
        // 16.049563, 108.222223
        // 16.061193, 108.232266

        // 16.056800, 108.232480
        $check = [0,1,1,0,1,1];
        $positions = [
            [
                'latitude' => 16.059915,
                'longitude' => 108.211108
            ],
            [
                'latitude' => 16.049563,
                'longitude' => 108.222223
            ],
            [
                'latitude' => 16.061193,
                'longitude' => 108.232266
            ],
            [
                'latitude' => 16.068534,
                'longitude' => 108.220421
            ],
            [
                'latitude' => 16.068534,
                'longitude' => 108.220421
            ],
            [
                'latitude' => 16.065606,
                'longitude' => 108.197075
            ],
//            [
//                'latitude' => 16.056800,
//                'longitude' => 108.232480
//            ]
        ];
//        $requestShipPositions = DB::table('request_ships')
//            ->select('pickup_location', 'destination')
//            ->limit(2)->get();
//        foreach ($requestShipPositions as $item) {
//            $pickupLocation = json_decode($item->pickup_location, true);
//            $destination = json_decode($item->destination, true);
//
//            array_push($positions, $pickupLocation, $destination);
//
//        }
//        dd($positions);
        $routingSearch = new RoutingSearchService($positions);

//        $arr = array_replace(array_flip($routingSearch->getBestRoute()), $positions);
//        echo "<pre>";
//        foreach ($arr as $a) {
//            print_r($a);
//        }
//        echo "</pre>";
//        dd($arr);
        $data = [];
        foreach ($routingSearch->getBestRoute() as $pos) {
            $temp =  $positions[$pos]['latitude'] . ',' . $positions[$pos]['longitude'];
            array_push($data, $temp);
        }
        return response()->json(['data' => $data], 200);
        dd($data);
        dd($routingSearch->getBestRoute());

    }
}

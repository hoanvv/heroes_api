<?php

namespace App\Http\Controllers;

use App\Entities\RequestShip;
use Illuminate\Http\Request;
use Ivory\GoogleMap\Service\DistanceMatrix\DistanceMatrixService;
use Http\Adapter\Guzzle6\Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Service\DistanceMatrix\Request\DistanceMatrixRequest;
use Ivory\GoogleMap\Service\Base\TravelMode;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Service\Base\Location\CoordinateLocation;

class MapController extends Controller
{
    public function index()
    {
        $distanceMatrix = new DistanceMatrixService(
            new Client(),
            new GuzzleMessageFactory()
        );

        $requestShip = RequestShip::find(5);

        $pickupArray = $requestShip->getCoordinateFromPickupLocation();
        $destinationArray = $requestShip->getCoordinateFromDestination();


        $pickup = new CoordinateLocation(
            new Coordinate(
                $pickupArray['latitude'],
                $pickupArray['longitude']
            )
        );
        $destination = new CoordinateLocation(
            new Coordinate(
                $destinationArray['latitude'],
                $destinationArray['longitude']
            )
        );
        $request = new DistanceMatrixRequest(
            [$pickup],
            [$destination]
        );

        $request->setTravelMode(TravelMode::DRIVING);

        $response = $distanceMatrix->process($request);

        dd($response->getRows()[0]);
    }
}

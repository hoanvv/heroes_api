<?php

namespace App\Http\Controllers;

use App\Entities\RequestShip;
use App\Traits\DistanceMatrixServiceCustom;
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
    use DistanceMatrixServiceCustom;

    public function index()
    {
        $distanceMatrix = new DistanceMatrixService(
            new Client(),
            new GuzzleMessageFactory()
        );

        $requestShip = RequestShip::find(14);

        $pickupTemp = $requestShip->getCoordinateFromPickupLocation();
        $destinationTemp = $requestShip->getCoordinateFromDestination();
//        $pickupTemp['latitude'] = 16.058580;
//        $pickupTemp['longitude'] = 108.206303;
//        $destinationTemp['latitude'] = 16.017873;
//        $destinationTemp['longitude'] = 108.231403;

        $pickup = $this->getCoordinateFromArray($pickupTemp);
        $destination = $this->getCoordinateFromArray($destinationTemp);
        for ($i = 1; $i < 20; $i++) {
            $response = $this->getDistanceMatrix($pickup, $destination);
        }

        echo $this->getDistanceFromResponse($response);
    }
}

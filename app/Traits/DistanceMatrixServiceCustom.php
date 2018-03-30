<?php

namespace App\Traits;

use Ivory\GoogleMap\Service\DistanceMatrix\DistanceMatrixService;
use Http\Adapter\Guzzle6\Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Service\DistanceMatrix\Request\DistanceMatrixRequest;
use Ivory\GoogleMap\Service\Base\TravelMode;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Service\Base\Location\CoordinateLocation;

trait DistanceMatrixServiceCustom
{
    private function getDistanceMatrixService()
    {
        $distanceMatrix = new DistanceMatrixService(
            new Client(),
            new GuzzleMessageFactory()
        );

        return $distanceMatrix;
    }

    protected function getCoordinateFromArray($coordinateArray)
    {
        $coordinate = new CoordinateLocation(
            new Coordinate(
                $coordinateArray['latitude'],
                $coordinateArray['longitude']
            )
        );
    }
}
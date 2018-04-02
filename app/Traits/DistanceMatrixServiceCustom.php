<?php

namespace App\Traits;

use Ivory\GoogleMap\Service\DistanceMatrix\DistanceMatrixService;
use Http\Adapter\Guzzle6\Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Service\DistanceMatrix\Request\DistanceMatrixRequest;
use Ivory\GoogleMap\Service\Base\TravelMode;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Service\Base\Location\CoordinateLocation;
use Ivory\GoogleMap\Service\DistanceMatrix\Response\DistanceMatrixResponse;

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

        return $coordinate;
    }

    protected function getDistanceMatrix($start, $end, $mode = 'DRIVING')
    {
        $request = new DistanceMatrixRequest(
            [$start],
            [$end]
        );
        switch ($mode) {
            case "DRIVING":
                $travelMode = TravelMode::DRIVING;
                break;
            case "BICYCLING":
                $travelMode = TravelMode::BICYCLING;
                break;
            case "WALKING":
                $travelMode = TravelMode::WALKING;
                break;
            case "TRANSIT":
                $travelMode = TravelMode::TRANSIT;
                break;
        }
        $request->setTravelMode($travelMode);

        $distanceMatrix = $this->getDistanceMatrixService();
        $response = $distanceMatrix->process($request);

        return $response;
    }

    protected function getDistanceFromResponse(DistanceMatrixResponse $response)
    {
        $firstRow = $response->getRows()[0];
        $firstElement = $firstRow->getElements()[0];
        $distance = $firstElement->getDistance();

        return $distance->getValue();
    }

    protected function getDurationFromResponse(DistanceMatrixResponse $response)
    {
        $firstRow = $response->getRows()[0];
        $firstElement = $firstRow->getElements()[0];
        $duration = $firstElement->getDuration();

        return $duration->getValue();
    }
}
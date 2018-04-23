<?php
/**
 * Created by PhpStorm.
 * User: harley
 * Date: 4/5/18
 * Time: 9:44 AM
 */

namespace App\Services;

use App\Traits\DistanceMatrixServiceCustom;

class RoutingSearchService
{
    use DistanceMatrixServiceCustom;

    private $distanceMatrix;
    private $positions;

    private $bestWay;
    private $free;
    private $t;
    private $x;
    private $positionNumber;
    private $minSpending;
    private $pairPos;
    private $odd;
    private $destination;

    public function __construct($positions, $pairPos, $destination)
    {
        $this->positionNumber = sizeof($positions);
        $this->free = array_fill(0, $this->positionNumber, 1);
        $this->free[0] = 0;
        $this->t[0] = 0;
        $this->x[0] = 0;
        $this->minSpending = 100000000;
        $this->odd = 0;
        $this->pairPos = $pairPos;
        $this->destination = $destination ?: null;
        $this->positions = $positions;
        $this->createDistanceMatrix();

        $this->search(1);
    }

    private function createDistanceMatrix()
    {
        $positions = $this->positions;
        if ($this->destination) {
            array_push($positions, $this->destination);
        }
        $length = sizeof($positions);
        for ($i = 0; $i < $length; $i++) {
            for ($j = $i + 1; $j < $length; $j++) {
                $startPoint = $this->getCoordinateFromArray($positions[$i]);
                $endPoint = $this->getCoordinateFromArray($positions[$j]);
                $response = $this->getDistanceMatrix($startPoint, $endPoint);
                $distance = $this->getDistanceFromResponse($response);

                $this->distanceMatrix[$i][$j] = $distance;
                $this->distanceMatrix[$j][$i] = $distance;
            }
            $this->distanceMatrix[$i][$i] = 0;
        }
    }

    private function search($i)
    {
        for ($j = 1; $j < $this->positionNumber; $j++) {
            if ($this->free[$j]) {
                if ($this->pairPos[$j] == 0) {
                    $this->odd = (int)(!$this->odd);
                } elseif ($j % 2 == $this->odd && $this->free[$j - 1] == 1) {
                    continue;
                } else {

                }

                $this->x[$i] = $j;
                $this->t[$i] = $this->t[$i-1] + $this->distanceMatrix[$this->x[$i-1]][$j];

                if ($this->t[$i] < $this->minSpending) {
                    $this->free[$j] = 0;
                    if ($i == $this->positionNumber - 1) {
                        $distance = $this->destination ? $this->distanceMatrix[$this->x[$i]][$this->positionNumber] : 0;
                        $totalDistance = $this->t[$this->positionNumber - 1] + $distance;

                        if ( $totalDistance < $this->minSpending ) {
                            for ($ii = 0; $ii < $this->positionNumber; $ii++) {
                                $this->bestWay[$ii] = $this->x[$ii];
                            }

                            if ($this->destination) {
                                $this->bestWay[$this->positionNumber] = $this->positionNumber;
                            }
                            $this->minSpending = $totalDistance;
                        }
                    } else {
                        $this->search($i + 1);
                    }
                    $this->free[$j] = 1;
                }
            }


        }
    }
    public function getMatrix()
    {
        return $this->distanceMatrix;
    }

    public function getBestRoute()
    {
        return $this->bestWay;
    }
}
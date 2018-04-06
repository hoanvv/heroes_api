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

    public function __construct($positions, $pairPos)
    {
        $this->positionNumber = sizeof($positions);
        $this->free = array_fill(0, $this->positionNumber, 1);
        $this->free[0] = 0;
        $this->t[0] = 0;
        $this->x[0] = 0;
        $this->minSpending = 100000000;
        $this->odd = 0;
        $this->pairPos = $pairPos;

        $this->positions = $positions;
        $this->createDistanceMatrix();

        $this->search(1);
    }

    private function createDistanceMatrix()
    {
        $length = sizeof($this->positions);
        for ($i = 0; $i < $length; $i++) {
            for ($j = $i + 1; $j < $length; $j++) {
                $startPoint = $this->getCoordinateFromArray($this->positions[$i]);
                $endPoint = $this->getCoordinateFromArray($this->positions[$j]);
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
                } elseif ($j % 2 == 0 && $this->free[$j - 1] == 1) {
                    continue;
                } else {

                }

                $this->x[$i] = $j;
                $this->t[$i] = $this->t[$i-1] + $this->distanceMatrix[$this->x[$i-1]][$j];
                // echo $distanceMatrix[0][1];
                // break;
                if ($this->t[$i] < $this->minSpending) {
                    $this->free[$j] = 0;
                    if ($i == $this->positionNumber - 1) {
                        if ( $this->t[$this->positionNumber - 1] < $this->minSpending )
                        {
                            for ($ii = 0; $ii < $this->positionNumber; $ii++) {
                                $this->bestWay[$ii] = $this->x[$ii];

                            }

                            $this->minSpending = $this->t[$this->positionNumber - 1];
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
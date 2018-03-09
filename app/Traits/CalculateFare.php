<?php

namespace App\Traits;


use App\Entities\PackageWeight;
use Illuminate\Support\Facades\DB;

trait CalculateFare
{
    protected function calculateFare($distance, $duration, $volumetricWeight, PackageWeight $packageWeight)
    {
        // VND
        $baseFare = 10000.0;
        $distanceRate = 1000.0;
        $durationRate = 100.0;
        $freeDistance = 2;

        // Calculate weight price
        $weightPrice = $this->calculateWeightPriceFromVolumetricWeight($volumetricWeight, $packageWeight);

        // Compare distance with free distance
        if ($distance <= $freeDistance) {
            $totalFare = $baseFare;
        } else {
            $distancePrice = $distanceRate * ($distance - $freeDistance);
            $durationPrice = $durationRate * $duration / 60;

            $totalFare = $baseFare + $distancePrice + $durationPrice + $weightPrice;
        }

        return $totalFare;
    }

    protected function calculateVolumetricWeight($length, $width, $height)
    {
        // Air shipment volumetric weight constant
        $ASVWC = 167; // kgs/cbm
        // Meter
        $lengthMeter = $length / 100.0;
        $widthMeter = $width / 100.0;
        $heightMeter = $height / 100.0;
        // Volumetric Weight
        $volumetricWeight = ($lengthMeter * $widthMeter * $heightMeter) * $ASVWC;

        return $volumetricWeight;
    }

    private function calculateWeightPriceFromVolumetricWeight($volumetricWeight, PackageWeight $actualPackageWeight)
    {
        $weightPrice = 0;
        $endActualWeight = $actualPackageWeight->end_weight;

        if ($endActualWeight < $volumetricWeight) {

            $biggestPackage = DB::table('package_weights')
                ->orderBy('end_weight', 'desc')->first();

            if ($volumetricWeight > $biggestPackage->end_weight) {
                $weightPrice = $biggestPackage->price;

            } else {
                $packageWeights = PackageWeight::where('end_weight', '>', $volumetricWeight)
                    ->get();

                foreach ($packageWeights as $packageWeight) {
                    $startWeight = $packageWeight->start_weight;
                    $endWeight = $packageWeight->end_weight;

                    if ($startWeight <= $volumetricWeight && $endWeight > $volumetricWeight) {
                        $weightPrice = $packageWeight->price;
                        break;

                    }
                }
            }
        } else {
            $weightPrice = $actualPackageWeight->price;

        }

        return $weightPrice;
    }
}
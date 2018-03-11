<?php

namespace App\Traits;


use App\Entities\PackageType;
use Illuminate\Support\Facades\DB;

trait CalculateFare
{
    protected function calculateFare($distance, $duration, $packageTypePrice)
    {
        // VND
        $baseFare = 10000.0;
        $distanceRate = 1000.0;
        $durationRate = 100.0;
        $freeDistance = 2;

        // Compare distance with free distance
        if ($distance <= $freeDistance) {
            $totalFare = $baseFare;
        } else {
            $distancePrice = $distanceRate * ($distance - $freeDistance);
            $durationPrice = $durationRate * $duration;

            $totalFare = $baseFare + $distancePrice + $durationPrice + $packageTypePrice;
        }

        return $totalFare;
    }

    private function calculateVolumetricWeight($length, $width, $height)
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

    protected function calculateWeightPriceFromVolumetricWeight($length, $width, $height, PackageType $actualPackageType)
    {
        $packageTypePrice = 0;
        $endActualWeight = $actualPackageType->end_weight;
        // Calculate volumetric weight from size
        $volumetricWeight = $this->calculateVolumetricWeight($length, $width, $height);
        // Calculate package type price
        if ($endActualWeight < $volumetricWeight) {

            $biggestPackage = DB::table('package_types')
                ->where('optional_package', PackageType::OPTIONAL_PACKAGE)
                ->orderBy('end_weight', 'desc')->first();

            if ($volumetricWeight > $biggestPackage->end_weight) {
                $packageTypePrice = $biggestPackage->price;

            } else {
                $packageTypes = PackageType::where([
                    'end_weight', '>', $volumetricWeight,
                    'optional_package', PackageType::OPTIONAL_PACKAGE
                ])->get();

                foreach ($packageTypes as $packageType) {
                    $startWeight = $packageType->start_weight;
                    $endWeight = $packageType->end_weight;

                    if ($startWeight <= $volumetricWeight && $endWeight > $volumetricWeight) {
                        $packageTypePrice = $packageType->price;
                        break;

                    }
                }
            }
        } else {
            $packageTypePrice = $actualPackageType->price;

        }

        return $packageTypePrice;
    }
}
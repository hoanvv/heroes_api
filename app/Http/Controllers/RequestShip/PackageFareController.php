<?php

namespace App\Http\Controllers\RequestShip;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Entities\PackageType;
use App\Traits\CalculateFare;

class PackageFareController extends Controller
{
    use CalculateFare;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rules = [
            'package_type_id' => 'required|integer',
            'size' => 'string|json',
            'distance' => 'required|numeric',
            'duration' => 'required|integer'
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $packageType = PackageType::findOrFail($data['package_type_id']);

        if ($packageType->isOptional() && $request->has('size')) {
            $size = json_decode($data['size']);
            $packageTypePrice = $this->calculateWeightPriceFromVolumetricWeight(
                $size->length,
                $size->width,
                $size->height,
                $packageType
            );
        } else {
            $packageTypePrice = $packageType->price;
        }
        // Convert units
        $data['distance'] /= 1000; // from meter to kilometer
        $data['duration'] /= 60; // from second to minute

        $price = $this->calculateFare(
            $data['distance'],
            $data['duration'],
            $packageTypePrice
        );

        return response()->json(['price' => $price], 200);
    }
}

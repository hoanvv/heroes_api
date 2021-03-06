<?php

namespace App\Http\Controllers\Shipper;

use App\Entities\Shipper;
use App\Entities\User;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipperController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $baseShipper = Auth::user()->only([
            'id',
            'first_name',
            'last_name',
            'email',
            'phone',
        ]);

        $individualShipper = Auth::user()->shipper()->first()->only([
            'rating',
            'avatar',
            'identity_card'
        ]);

        $shipper = array_merge($baseShipper, $individualShipper);

        return response()->json(['data' => $shipper], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ];

        $this->validate($request, $rules);
        $data = $request->all();

        $shipper = Auth::user()->shipper()->first();

        if ($shipper->id != $id) {
            $message = array(
                'success' => false,
                'message' => "You are cheated",
                'code' => 401
            );
            $status = 401;
        } else {
            $shipper->latitude = $data['latitude'];
            $shipper->longitude = $data['longitude'];

            $shipper->save();

            $message = array(
                'success' => true,
                'message' => "Updated the shipper's current location",
                'code' => 200
            );
            $status = 200;
        }

        return response()->json($message, $status);
    }

    public function changeShippingStatus(Request $request)
    {
        $shipper = Auth::user()->shipper()->first();

        $notCompletedTrip = Shipper::getNotCompletedRequestShipList($shipper->id);

        if ($notCompletedTrip && $shipper->is_online == Shipper::ONLINE_SHIP) {
            $message = array(
                'success' => false,
                'message' => "You cannot turn off if you dont complete to deliver all package that you picked up",
                'code' => 403
            );
            return response()->json($message, 403);
        }

        $shipper->is_online = (int)!$shipper->is_online;
        $shipper->save();

        if ($shipper->is_online) {
            $value = "You are online";
        } else {
            $value = "You are offline";
        }

        $message = array(
            'success' => true,
            'message' => $value,
            'code' => 200
        );
        return response()->json($message, 200);

    }

    public function statisticOutcome($factor)
    {
        $uppercasedFactor = strtoupper($factor);
        $array = ['DAILY', 'WEEKLY', 'MONTHLY'];
        if (!in_array(strtoupper($factor), $array)) {
            $message = array(
                'success' => false,
                'message' => "Not found",
                'code' => 404
            );
            $status = 404;
        } else {
            $shipper = Auth::user()->shipper()->first();
            $outcome = Shipper::getTotalOutcome($uppercasedFactor, $shipper->id);
            $message = ['data' => $outcome];
            $status = 200;
        }
        return response()->json($message, $status);
    }

    public function statisticOutcomeBasingOnFactors()
    {
        $shipper = Auth::user()->shipper()->first();
        $outcome = [];
        $outcome['daily'] = Shipper::getTotalOutcome('DAILY', $shipper->id);
        $outcome['weekly'] = Shipper::getTotalOutcome('WEEKLY', $shipper->id);
        $outcome['monthly'] = Shipper::getTotalOutcome('MONTHLY', $shipper->id);

        $message = ['data' => $outcome];
        $status = 200;

        return response()->json($message, $status);
    }
}

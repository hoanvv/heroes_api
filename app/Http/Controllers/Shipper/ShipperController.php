<?php

namespace App\Http\Controllers\Shipper;

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

}

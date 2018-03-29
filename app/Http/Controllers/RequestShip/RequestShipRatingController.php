<?php

namespace App\Http\Controllers\RequestShip;

use App\Entities\RequestTracking;
use App\Entities\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class RequestShipRatingController extends Controller
{
    public function index(Request $request)
    {
        $rules = [
            'request_ship_id' => 'required|integer',
            'rating' => 'required|numeric'
        ];

        $this->validate($request, $rules);
        $data = $request->all();

        $user = Auth::user();
        $trip = Trip::where('request_ship_id', $data['request_ship_id'])->first();

        $finalTracking = RequestTracking::where([
            ['request_ship_id', $data['request_ship_id']],
            ['status', 4]
        ]);

        if (empty($finalTracking)) {
            $message = array(
                'success' => false,
                'message' => "The trip couldn't be evaluated ",
                'code' => 403
            );
            return response()->json($message, 403);
        } else {

        }

    }
}

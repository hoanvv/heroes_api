<?php

namespace App\Http\Controllers\RequestShip;

use App\Entities\RequestShip;
use App\Entities\RequestTracking;
use App\Entities\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class RequestShipRatingController extends Controller
{
    public function index(Request $request)
    {
        $rules = [
            'request_ship_id' => 'required|integer',
            'rating' => 'required|numeric',
            'package_owner_comment' => 'string'
        ];

        $this->validate($request, $rules);
        $data = $request->all();

        $requestShip = RequestShip::findOrFail($data['request_ship_id']);
        $user = Auth::user();
        $trip = Trip::where('request_ship_id', $data['request_ship_id'])->first();
        $shipper = $trip->shipper()->first();

        $totalDeliveredTrip = DB::select(
            'SELECT count(t.id) as total'
            . ' FROM trips t'
            . ' JOIN request_ships rs ON (rs.id = t.request_ship_id)'
            . ' JOIN request_trackings rt ON (rt.request_ship_id = rs.id)'
            . ' WHERE t.shipper_id  = :shipper_id AND rt.status = 4',
            ['shipper_id' => $shipper->id]
        )[0];

        $finalTracking = RequestTracking::where([
            ['request_ship_id', $data['request_ship_id']],
            ['status', 4]
        ])->first();

        if (empty($finalTracking) || $requestShip->user_id != $user->id) {
            $message = array(
                'success' => false,
                'message' => "The trip couldn't be evaluated ",
                'code' => 403
            );
            return response()->json($message, 403);
        } elseif ($trip->shipper_rating === null) {

            $total = $totalDeliveredTrip->total;
            $currentRating = $shipper->rating;
            $rating = ($currentRating * $total + $data['rating']) / ($total + 1);

            if ($request->has('package_owner_comment')) {
                $trip->package_owner_comment = $data['package_owner_comment'];
            }

            $trip->shipper_rating = $data['rating'];
            $trip->save();

            $shipper->rating = $rating;
            $shipper->save();

            $message = array(
                'success' => true,
                'message' => "The trip was evaluated successfully",
                'code' => 200
            );
            return response()->json($message, 200);
        } else {
            $message = array(
                'success' => false,
                'message' => "The trip was be evaluated. You couldn't evaluate it again",
                'code' => 403
            );
            return response()->json($message, 403);
        }

    }
}

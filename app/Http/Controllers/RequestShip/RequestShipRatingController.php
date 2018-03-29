<?php

namespace App\Http\Controllers\RequestShip;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestShipRatingController extends Controller
{
    public function index(Request $request)
    {
        $rules = [
            'request_ship_id' => 'required|integer',
            'rating_number' => 'required|numeric'
        ];

        $this->validate($request, $rules);


    }
}

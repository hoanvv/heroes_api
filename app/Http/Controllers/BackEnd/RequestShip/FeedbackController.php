<?php

namespace App\Http\Controllers\BackEnd\RequestShip;

use App\Entities\RequestShip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function index()
    {
        $requestShips = RequestShip::getCompletedRequestShipList();
        return view('back-end.pages.request-ship.feedback', compact('requestShips'));
    }
}

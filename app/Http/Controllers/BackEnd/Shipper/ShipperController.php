<?php

namespace App\Http\Controllers\BackEnd\Shipper;

use App\Entities\Shipper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShipperController extends Controller
{
    public function index()
    {
        $shippers = Shipper::with('user')->get();
        return view('back-end.pages.shipper.list', compact('shippers'));
    }
}

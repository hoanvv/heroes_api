<?php

namespace App\Http\Controllers\BackEnd\RequestShip;

use App\Entities\RequestShip;
use App\Entities\Shipper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestShipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requestShips = RequestShip::getRequestShipList();
        return view('back-end.pages.request-ship.list', compact('requestShips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $requestShip = RequestShip::findOrFail($id);
        $requestShipMore = RequestShip::getRequestShip($id);
        $status = $requestShipMore->status;
        $shipperId = $requestShipMore->shipper_id;
        if ($shipperId) {
            $shipper = Shipper::findOrFail($shipperId)->user;
        } else {
            $shipper = null;
        }
//        dd($requestShip->pickup_location);
        return view('back-end.pages.request-ship.show', compact(['requestShip', 'status', 'shipper']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

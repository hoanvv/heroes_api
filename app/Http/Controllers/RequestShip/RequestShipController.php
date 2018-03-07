<?php

namespace App\Http\Controllers\RequestShip;

use App\Entities\RequestShip;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use App\Entities\Shipper;

class RequestShipController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippers = Shipper::all();

        return $this->showAll($shippers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'package_type_id' => 'integer',
            'promo_code_id' => 'integer',
            'receiver_name' => 'required|string|max:100',
            'receiver_phone' => 'required|string|max:20',
            'pickup_location' => 'required|json',
            'destination' => 'required|json',
            'note' => 'text'
        ];

        $this->validate($request, $rules);

        // Prepare data for request ship before insert
        $requestShipData = $request->all();
        $requestShipData['user_id'] = 3;
        $requestShipData['price'] = 20000.0;
        $requestShipData['distance'] = 5.3;

        // Prepare data for request tracking before insert


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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

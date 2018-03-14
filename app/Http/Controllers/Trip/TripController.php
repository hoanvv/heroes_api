<?php

namespace App\Http\Controllers\Trip;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @SWG\Post(
     *     path="/trips",
     *     tags={"Trips"},
     *     summary="Choose a request ship for delivering",
     *     @SWG\Parameter(
     * 			name="id",
     * 			in="body",
     *          schema={"$ref": "#/definitions/NewTrip"},
     * 			required=true,
     * 			type="integer",
     * 			description="ID",
     * 		),
     *     @SWG\Response(
     *          response=201,
     *          description="A newly-created trip",
     *          @SWG\Schema(ref="#/definitions/Trip")
     *      ),
     *     @SWG\Response(
     *          response="default",
     *          description="error",
     *          @SWG\Schema(ref="#/definitions/Error")
     *   )
     * ),
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

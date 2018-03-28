<?php

namespace App\Http\Controllers\PackageOwner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PackageOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $base = Auth::user()->only([
            'id',
            'first_name',
            'last_name',
            'email',
            'phone',
        ]);

        $individual = Auth::user()->packageOwner()->first()->only([
            'rating'
        ]);

        $infor = array_merge($base, $individual);

        return response()->json(['data' => $infor], 200);
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

}

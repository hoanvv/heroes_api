<?php

use Illuminate\Http\Request;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/*
 * Request Ship
*/
Route::get('requestShips/packageFare', 'RequestShip\PackageFareController@index');
Route::apiResource('requestShips', 'RequestShip\RequestShipController');
/*
* Package type
*/
Route::apiResource('packageTypes', 'PackageType\PackageTypeController');
//Route::get('getPackageFare', 'RequestShip\RequestShipController@getPackageFare');

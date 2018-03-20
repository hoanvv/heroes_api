<?php

use Illuminate\Http\Request;

//Route::post('register', 'Auth/AuthController@register');
Route::post('login', 'Auth\AuthController@login');
//Route::post('recover', 'Auth/AuthController@recover');
Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'Auth\AuthController@logout');
});

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
Route::get('packageTypes/optional', 'PackageType\PackageTypeController@getOptionalPackageTypes');
Route::get('packageTypes/normal', 'PackageType\PackageTypeController@getNormalPackageTypes');
/*
* Trip
*/
Route::apiResource('trips', 'Trip\TripController');
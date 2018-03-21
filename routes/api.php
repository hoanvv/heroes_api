<?php

use Illuminate\Http\Request;

//Route::post('register', 'Auth/AuthController@register');
//Route::post('recover', 'Auth/AuthController@recover');
Route::post('login', 'Auth\AuthController@login');

Route::group(['middleware' => ['jwt.auth']], function() {
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
    Route::get('logout', 'Auth\AuthController@logout');
});

Route::group(['middleware' => ['jwt.auth', 'role:shipper']], function() {
    // Request Ship
    Route::post('shipper/trip', 'Shipper\ShipperTripController@store');

});

Route::group(['middleware' => ['jwt.auth', 'role:packageOwner']], function() {

});

/*
 * Request Ship
*/
//Route::get('requestShips/packageFare', 'RequestShip\PackageFareController@index');
//Route::apiResource('requestShips', 'RequestShip\RequestShipController');
/*
* Package type
*/
//Route::get('packageTypes/optional', 'PackageType\PackageTypeController@getOptionalPackageTypes');
//Route::get('packageTypes/normal', 'PackageType\PackageTypeController@getNormalPackageTypes');
/*
* Trip
*/
//Route::apiResource('trips', 'Trip\TripController');
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
    // Shipper information
    Route::get('shipper/online', 'Shipper\ShipperController@changeShippingStatus');
    Route::apiResource('shippers', 'Shipper\ShipperController', ['except' => [
        'destroy', 'show', 'store'
    ]]);
    // Request Ship
    Route::apiResource('shipper/trip', 'Shipper\ShipperTripController');
    // Verify receiver verification code
    Route::put('receiver/trip/{requestShipId}', 'Shipper\ReceiverTripController@update');
    // Shortest route
    Route::get('shortestRoute', 'Shipper\ShortestRouteController@index');
    // stistic outcome
    Route::get('shipper/outcome/{factor}', 'Shipper\ShipperController@statisticOutcome');
    Route::get('shipper/outcome', 'Shipper\ShipperController@statisticOutcomeBasingOnFactors');
});

Route::group(['middleware' => ['jwt.auth', 'role:packageOwner']], function() {
    // Request Ship
    Route::apiResource('packageOwner/trip', 'PackageOwner\PackageOwnerTripController', ['except' => [
        'update'
    ]]);
    // PO information
    Route::apiResource('packageOwners', 'PackageOwner\PackageOwnerController', ['except' => [
        'destroy', 'show', 'store'
    ]]);
    // PO rating
    Route::post('requestShips/rating', 'RequestShip\RequestShipRatingController@index');
});

Route::get('/sendSMS/{phoneNumber}', 'SMSController@index');
Route::get('/verifyCode/{phoneNumber}/{verificationCode}', 'SMSController@verifyCode');

Route::get('/qrcode', 'SMSController@createQR');
Route::get('/map', 'MapController@index');
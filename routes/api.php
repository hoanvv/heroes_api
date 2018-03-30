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
    Route::apiResource('shippers', 'Shipper\ShipperController', ['except' => [
        'destroy', 'show', 'store'
    ]]);
    // Request Ship
    Route::apiResource('shipper/trip', 'Shipper\ShipperTripController');
//    Route::get('shipper/trip', 'Shipper\ShipperTripController@index');
//    // Pick up package
//    Route::post('shipper/trip', 'Shipper\ShipperTripController@store');
//    // Verify Po verification code
//    Route::put('shipper/trip/{requestShipId}', 'Shipper\ShipperTripController@update');
    // Verify receiver verification code
    Route::put('receiver/trip/{requestShipId}', 'Shipper\ReceiverTripController@update');

});

Route::group(['middleware' => ['jwt.auth', 'role:packageOwner']], function() {
    // Request Ship

//    Route::get('packageOwner/trip', 'PackageOwner\PackageOwnerTripController@index');
//    Route::get('packageOwner/trip/{$id}', 'PackageOwner\PackageOwnerTripController@index');
    // Verify OTP
//    Route::put('packageOwner/trip/{requestShipId}', 'PackageOwner\PackageOwnerTripController@update');
    // PO information
    Route::apiResource('packageOwner/trip', 'PackageOwner\PackageOwnerTripController');
    Route::apiResource('packageOwners', 'PackageOwner\PackageOwnerController', ['except' => [
        'destroy', 'show', 'store'
    ]]);

    Route::post('requestShips/rating', 'RequestShip\RequestShipRatingController@index');
});

Route::get('/sendSMS/{phoneNumber}', 'SMSController@index');
Route::get('/verifyCode/{phoneNumber}/{verificationCode}', 'SMSController@verifyCode');

Route::get('/qrcode', 'SMSController@createQR');
Route::get('/map', 'MapController@index');
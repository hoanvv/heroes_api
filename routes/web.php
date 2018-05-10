<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/api/documentation');
});

// Route for admin page
Route::prefix('admin')->group(function () {

    Route::get('login', 'BackEnd\LoginController@index')->name('admin.login');
    Route::post('login', 'BackEnd\LoginController@login');
    Route::get('/', 'BackEnd\HomeController@index')->name('admin.home');
    Route::post('logout', 'BackEnd\LoginController@logout')->name('admin.logout');
    Route::resource('delivery-request', 'BackEnd\RequestShip\RequestShipController');
    Route::resource('shipper', 'BackEnd\Shipper\ShipperController');
    Route::resource('feedback', 'BackEnd\RequestShip\FeedbackController');
    Route::get('shipper/{id}/document', 'BackEnd\Document\DocumentController@index');
    Route::get('shipper/{shipperId}/changeStatus', 'BackEnd\Shipper\ShipperController@changeShippingStatus');
    Route::get('shipper/{shipperId}/outcome', 'BackEnd\Shipper\ShipperController@showOutcome');
    Route::get('shipper/{shipperId}/block', 'BackEnd\Shipper\ShipperController@BlockShipper');
    Route::resource('po', 'BackEnd\PackageOwner\PackageOwnerController');
    Route::get('po/{id}/block', 'BackEnd\PackageOwner\PackageOwnerController@BlockActivity');
    Route::resource('package-type', 'BackEnd\PackageType\PackageTypeController');
});
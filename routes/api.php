<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/tracking/{clientID}', ['uses' => 'API\ClientTrackingController@index']);
Route::get('/city/{countryID}', ['uses' => 'API\CityController@index']);
Route::get('/client/list/{cityID}', ['uses' => 'API\ClientController@index']);

Route::apiResource('country', 'API\CountryController');
Route::apiResource('city', 'API\CityController');
Route::apiResource('client', 'API\ClientController');
Route::apiResource('tracking', 'API\ClientTrackingController');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

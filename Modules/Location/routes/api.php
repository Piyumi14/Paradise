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

Route::prefix('location')->group(function () {
    Route::get('get-country-list', 'LocationController@getCountryList');
    Route::get('get-province-list', 'LocationController@getProvinceList');
    Route::get('get-district-by-province/{id}', 'LocationController@getDistrictByProvinceId');
});

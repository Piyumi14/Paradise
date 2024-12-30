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

Route::middleware('auth:api')->group(function () {
    Route::prefix('invitation')->group(function () {
        Route::post('send', 'InvitationController@sendInvitation');
        Route::post('update-status-of-sent', 'InvitationController@updateSentInvitationStatus');
        Route::post('update-status-of-received', 'InvitationController@updateReceivedInvitationStatus');
        Route::get('get-all-sent', 'InvitationController@getAllSentInvitations');
        Route::get('get-all-received', 'InvitationController@getAllReceivedInvitations');
        Route::get('get-send-status/{proposal_id}', 'InvitationController@getSendInvitationStatus');
        Route::get('get-received-status/{proposal_id}', 'InvitationController@getReceivedInvitationStatus');
    });
});